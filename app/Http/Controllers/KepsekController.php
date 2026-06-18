<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class KepsekController extends Controller
{
    public function index()
    {
        $metrics = $this->getMetrics();
        $chartData = $this->getDailyRegistrationTrend();
        $staffList = $this->getStaffList();
        $pendingInvoices = $this->getInvoices('pending');
        $issuedInvoices = $this->getInvoices('valid');
        $studentReportRows = $this->getStudentReportRows();

        return view('dashboard_kepsek.dashboard', compact(
            'metrics',
            'chartData',
            'staffList',
            'pendingInvoices',
            'issuedInvoices',
            'studentReportRows'
        ));
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email'),
            ],
            'password' => ['required', 'string', 'min:6', 'max:100'],
        ], [
            'email.unique' => 'Email akses staf tersebut sudah terdaftar.',
        ]);

        DB::transaction(function () use ($validated) {
            $stafId = null;

            if (Schema::hasTable('staf_spmb')) {
                $stafId = DB::table('staf_spmb')->insertGetId([
                    'nama' => $validated['nama'],
                    'jabatan' => 'admin',
                ]);
            }

            DB::table('user')->insert([
                'uid_user' => $stafId ?? 0,
                'email' => $validated['email'],
                'hash_password' => Hash::make($validated['password']),
                'role' => 'admin',
                'create_at' => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('kepsek.dashboard', ['tab' => 'staf'])
            ->with('success', 'Akses admin SPMB baru berhasil diterbitkan.');
    }

    public function approveInvoice(Request $request, int $uid)
    {
        $validated = $request->validate([
            'catatan_kepsek' => ['nullable', 'string', 'max:255'],
            'diskon' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama_komponen' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'numeric', 'min:1'],
            'items.*.nominal' => ['required', 'numeric', 'min:0'],
        ]);

        $tagihan = Schema::hasTable('tagihan')
            ? DB::table('tagihan')->where('uid', $uid)->first()
            : null;

        if (! $tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice tidak ditemukan.',
            ], 404);
        }

        if (in_array(strtolower((string) $tagihan->status_tagihan), ['valid', 'terbit', 'approved'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice ini sudah final dan tidak bisa diubah lagi.',
            ], 409);
        }

        if (! Schema::hasTable('komponen_tagihan')) {
            return response()->json([
                'success' => false,
                'message' => 'Tabel komponen_tagihan belum tersedia.',
            ], 500);
        }

        $subtotalTagihan = 0;

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['qty'];
            $nominal = (float) $item['nominal'];
            $subtotalTagihan += $qty * $nominal;
        }

        $diskon = (float) ($validated['diskon'] ?? 0);
        $totalTagihan = max(0, $subtotalTagihan - $diskon);

        DB::transaction(function () use ($uid, $validated, $subtotalTagihan, $diskon, $totalTagihan) {
            $update = [
                'subtotal_tagihan' => $subtotalTagihan,
                'diskon_tagihan' => $diskon,
                'total_tagihan' => $totalTagihan,
                'status_tagihan' => 'valid',
                'tanggal_tagihan' => now(),
            ];

            if (Schema::hasColumn('tagihan', 'catatan_kepsek')) {
                $update['catatan_kepsek'] = $validated['catatan_kepsek'] ?? null;
            }

            if (Schema::hasColumn('tagihan', 'disetujui_oleh')) {
                $update['disetujui_oleh'] = session('email') ?? 'Kepala Sekolah';
            }

            if (Schema::hasColumn('tagihan', 'updated_at')) {
                $update['updated_at'] = now();
            }

            DB::table('tagihan')->where('uid', $uid)->update($update);

            DB::table('komponen_tagihan')
                ->where('uid_tagihan', $uid)
                ->delete();

            foreach ($validated['items'] as $index => $item) {
                $qty = (float) $item['qty'];
                $nominal = (float) $item['nominal'];

                DB::table('komponen_tagihan')->insert([
                    'uid_tagihan' => $uid,
                    'nama_komponen' => $item['nama_komponen'],
                    'qty' => $qty,
                    'nominal' => $nominal,
                    'subtotal' => $qty * $nominal,
                    'urutan' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Invoice final berhasil disetujui kepala sekolah. Orang tua akan otomatis melihat invoice terbaru.',
        ]);
    }

    public function printStudentReport()
    {
        $metrics = $this->getMetrics();
        $rows = $this->getStudentReportRows();

        return view('dashboard_kepsek.laporan_siswa', compact('metrics', 'rows'));
    }

    private function getMetrics(): array
    {
        $total = 0;
        $approved = 0;
        $rejected = 0;
        $pending = 0;
        $quota = 0;
        $activeBatch = null;
        $pendingInvoices = 0;
        $issuedInvoices = 0;

        if (Schema::hasTable('pendaftaran')) {
            $total = DB::table('pendaftaran')->count();
            $approved = DB::table('pendaftaran')->where('status_pendaftaran', 'approved')->count();
            $rejected = DB::table('pendaftaran')->where('status_pendaftaran', 'rejected')->count();
            $pending = DB::table('pendaftaran')
                ->where(function ($query) {
                    $query->whereNull('status_pendaftaran')
                        ->orWhereIn('status_pendaftaran', ['pending', 'proses', 'draft']);
                })
                ->count();
        }

        if (Schema::hasTable('batch_pendaftaran')) {
            $activeBatch = DB::table('batch_pendaftaran')
                ->where('is_active', 1)
                ->orderByDesc('tanggal_buka')
                ->orderByDesc('uid')
                ->first();

            if (! $activeBatch) {
                $activeBatch = DB::table('batch_pendaftaran')
                    ->orderByDesc('tanggal_buka')
                    ->orderByDesc('uid')
                    ->first();
            }

            $quota = (int) ($activeBatch->kuota ?? 0);
        }

        if (Schema::hasTable('tagihan')) {
            $pendingInvoiceQuery = DB::table('tagihan')
                ->where(function ($query) {
                    $query->whereNull('status_tagihan')
                        ->orWhere('status_tagihan', 'pending');
                });

            $issuedInvoiceQuery = DB::table('tagihan')
                ->whereIn('status_tagihan', ['valid', 'terbit', 'approved']);

            if (Schema::hasColumn('tagihan', 'disetujui_oleh')) {
                $pendingInvoiceQuery->orWhere(function ($query) {
                    $query->whereIn('status_tagihan', ['valid', 'terbit', 'approved'])
                        ->where(function ($subQuery) {
                            $subQuery->whereNull('disetujui_oleh')
                                ->orWhere('disetujui_oleh', '');
                        });
                });

                $issuedInvoiceQuery->whereNotNull('disetujui_oleh')
                    ->where('disetujui_oleh', '<>', '');
            }

            $pendingInvoices = $pendingInvoiceQuery->count();
            $issuedInvoices = $issuedInvoiceQuery->count();
        }

        $percentage = $quota > 0 ? min(100, round(($total / $quota) * 100, 1)) : 0;
        $remainingQuota = $quota > 0 ? max(0, $quota - $total) : 0;

        return [
            'total' => $total,
            'approved' => $approved,
            'rejected' => $rejected,
            'pending' => $pending,
            'quota' => $quota,
            'remaining_quota' => $remainingQuota,
            'percentage' => $percentage,
            'active_batch' => $activeBatch,
            'pending_invoices' => $pendingInvoices,
            'issued_invoices' => $issuedInvoices,
        ];
    }

    private function getDailyRegistrationTrend(): array
    {
        $days = collect(range(6, 0))->map(function ($offset) {
            return Carbon::today()->subDays($offset);
        })->push(Carbon::today());

        $counts = [];

        if (Schema::hasTable('pendaftaran')) {
            $start = $days->first()->toDateString();
            $end = Carbon::today()->toDateString();

            $counts = DB::table('pendaftaran')
                ->select(DB::raw('DATE(tanggal_daftar) as tanggal'), DB::raw('COUNT(*) as total'))
                ->whereDate('tanggal_daftar', '>=', $start)
                ->whereDate('tanggal_daftar', '<=', $end)
                ->groupBy(DB::raw('DATE(tanggal_daftar)'))
                ->pluck('total', 'tanggal')
                ->toArray();
        }

        return $days->map(function (Carbon $date) use ($counts) {
            $key = $date->toDateString();

            return [
                'label' => $date->format('d/m'),
                'day' => $date->translatedFormat('D'),
                'total' => (int) ($counts[$key] ?? 0),
            ];
        })->values()->toArray();
    }

    private function getStaffList()
    {
        if (! Schema::hasTable('user')) {
            return collect();
        }

        $query = DB::table('user')
            ->where('user.role', 'admin')
            ->select(
                'user.uid',
                'user.uid_user',
                'user.email',
                'user.role',
                'user.create_at'
            )
            ->orderByDesc('user.uid');

        if (Schema::hasTable('staf_spmb')) {
            $query->leftJoin('staf_spmb', 'staf_spmb.uid', '=', 'user.uid_user')
                ->addSelect('staf_spmb.nama as nama_staf', 'staf_spmb.jabatan');
        } else {
            $query->addSelect(DB::raw('NULL as nama_staf'), DB::raw('NULL as jabatan'));
        }

        return $query->get()->map(function ($row) {
            $row->nama_staf = $row->nama_staf ?: 'Admin SPMB';
            $row->initial = strtoupper(mb_substr($row->nama_staf, 0, 1));

            return $row;
        });
    }

    private function getInvoices(string $status)
    {
        if (! Schema::hasTable('tagihan')) {
            return collect();
        }

        $select = [
            'tagihan.uid',
            'tagihan.uid_pendaftaran',
            'tagihan.nomor_tagihan',
            'tagihan.subtotal_tagihan',
            'tagihan.diskon_tagihan',
            'tagihan.total_tagihan',
            'tagihan.status_tagihan',
            'tagihan.tanggal_tagihan',
            'tagihan.dibuat_oleh',
            'pendaftaran.no_pendaftaran',
            'calon_siswa.nama as nama_siswa',
            'calon_siswa.nik',
            'orang_tua.nama as nama_ortu',
        ];

        $select[] = Schema::hasColumn('tagihan', 'disetujui_oleh')
            ? 'tagihan.disetujui_oleh'
            : DB::raw('NULL as disetujui_oleh');

        $select[] = Schema::hasColumn('tagihan', 'catatan_kepsek')
            ? 'tagihan.catatan_kepsek'
            : DB::raw('NULL as catatan_kepsek');

        $query = DB::table('tagihan')
            ->leftJoin('pendaftaran', 'pendaftaran.uid', '=', 'tagihan.uid_pendaftaran')
            ->leftJoin('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->select($select);

        if ($status === 'pending') {
            $query->where(function ($q) {
                $q->whereNull('tagihan.status_tagihan')
                    ->orWhere('tagihan.status_tagihan', 'pending');

                if (Schema::hasColumn('tagihan', 'disetujui_oleh')) {
                    $q->orWhere(function ($subQuery) {
                        $subQuery->whereIn('tagihan.status_tagihan', ['valid', 'terbit', 'approved'])
                            ->where(function ($approvalQuery) {
                                $approvalQuery->whereNull('tagihan.disetujui_oleh')
                                    ->orWhere('tagihan.disetujui_oleh', '');
                            });
                    });
                }
            });
        } else {
            $query->whereIn('tagihan.status_tagihan', ['valid', 'terbit', 'approved']);

            if (Schema::hasColumn('tagihan', 'disetujui_oleh')) {
                $query->whereNotNull('tagihan.disetujui_oleh')
                    ->where('tagihan.disetujui_oleh', '<>', '');
            }
        }

        $invoices = $query->orderByDesc('tagihan.uid')->get();

        if ($invoices->isEmpty() || ! Schema::hasTable('komponen_tagihan')) {
            return $invoices->map(function ($invoice) {
                $invoice->komponen_tagihan = collect();
                return $invoice;
            });
        }

        $components = DB::table('komponen_tagihan')
            ->whereIn('uid_tagihan', $invoices->pluck('uid')->filter()->values()->all())
            ->orderBy('urutan')
            ->get()
            ->groupBy('uid_tagihan');

        return $invoices->map(function ($invoice) use ($components) {
            $invoice->komponen_tagihan = $components->get($invoice->uid, collect())->values();
            return $invoice;
        });
    }

    private function getStudentReportRows()
    {
        if (! Schema::hasTable('pendaftaran')) {
            return collect();
        }

        $query = DB::table('pendaftaran')
            ->leftJoin('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->leftJoin('batch_pendaftaran', 'batch_pendaftaran.uid', '=', 'pendaftaran.id_batch_pendaftaran')
            ->select(
                'pendaftaran.uid',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.tanggal_daftar',
                'calon_siswa.nama as nama_siswa',
                'calon_siswa.nik',
                'calon_siswa.tempat_lahir',
                'calon_siswa.tanggal_lahir',
                'calon_siswa.alamat',
                'orang_tua.nama as nama_ortu',
                'orang_tua.no_telp',
                'batch_pendaftaran.nama_batch'
            );

        if (Schema::hasTable('tagihan')) {
            $query->leftJoin('tagihan', 'tagihan.uid_pendaftaran', '=', 'pendaftaran.uid')
                ->addSelect('tagihan.nomor_tagihan', 'tagihan.total_tagihan', 'tagihan.status_tagihan');
        } else {
            $query->addSelect(
                DB::raw('NULL as nomor_tagihan'),
                DB::raw('0 as total_tagihan'),
                DB::raw('NULL as status_tagihan')
            );
        }

        return $query->orderByDesc('pendaftaran.uid')->get();
    }
}
