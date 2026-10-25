<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{

    private const BERKAS_KEY_BY_TYPE = [
        'Kartu Keluarga' => 'kartu_keluarga',
        'Akte Kelahiran' => 'akte_kelahiran',
        'E-KTP Orang Tua' => 'ktp_orang_tua',
        'Pas Foto' => 'pas_foto',
        'Surat Baptis' => 'surat_baptis',
    ];
    private function checkAdmin(): void
    {
        if (session('role') !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
    }

    private function mapBerkas(
        iterable $berkasSiswa,
        ?string $defaultValue = null
    ): array {
        $berkasMap = array_fill_keys(
            array_values(self::BERKAS_KEY_BY_TYPE),
            $defaultValue
        );

        foreach ($berkasSiswa as $item) {
            $key = self::BERKAS_KEY_BY_TYPE[$item->jenis_berkas] ?? null;

            if ($key === null) {
                continue;
            }

            $berkasMap[$key] = route('admin.berkas.show', [
                'uid' => $item->uid,
                'filename' => basename((string) $item->file_url),
            ]);
        }

        return $berkasMap;
    }

    public function index()
    {
        $this->checkAdmin();

        $pendaftar = DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->leftJoin('users', 'users.id', '=', 'orang_tua.user_id')
            ->select(
                'pendaftaran.uid as pendaftaran_uid',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.alasan_penolakan',
                'pendaftaran.tanggal_daftar',

                'calon_siswa.uid as calon_siswa_uid',
                'calon_siswa.nama',
                'calon_siswa.nik',
                'calon_siswa.tanggal_lahir',
                'calon_siswa.tempat_lahir',
                'calon_siswa.alamat',
                'calon_siswa.agama',
                'calon_siswa.golongan_darah',
                'calon_siswa.nomor_registrasi',

                'orang_tua.nama as nama_ortu',
                'orang_tua.no_telp',
                'orang_tua.pendidikan',
                'orang_tua.gaji',
                'orang_tua.alamat as alamat_ortu',

                'users.email as email_ortu'
            )
            ->orderByDesc('pendaftaran.uid')
            ->get();

        $pendaftaranIds = $pendaftar->pluck('pendaftaran_uid');

        $berkas = DB::table('berkas')
            ->whereIn('id_pendaftar', $pendaftaranIds)
            ->get()
            ->groupBy('id_pendaftar');

        $dataSiswa = $pendaftar->map(function ($row) use ($berkas) {
            $status = $row->status_pendaftaran ?? 'pending';

            $statusAdmin = match ($status) {
                'approved' => 'approved',
                'rejected' => 'rejected',
                'draft' => 'draft',
                default => 'proses',
            };

            $berkasSiswa = $berkas->get($row->pendaftaran_uid, collect());

            $berkasMap = $this->mapBerkas($berkasSiswa, '');

            return [
                'pendaftaran_uid' => $row->pendaftaran_uid,
                'id' => $row->no_pendaftaran ?? $row->nomor_registrasi ?? 'REG-' . $row->pendaftaran_uid,
                'nama' => $row->nama,
                'nik' => $row->nik,
                'tgl' => $row->tanggal_daftar,
                'status' => $statusAdmin,
                'alasan_rejected' => $row->alasan_penolakan,

                'tanggal_lahir' => $row->tanggal_lahir,
                'tempat_lahir' => $row->tempat_lahir,
                'alamat' => $row->alamat,
                'agama' => $row->agama,
                'gol_darah' => $row->golongan_darah,

                'nama_ortu' => $row->nama_ortu,
                'no_telp_ortu' => $row->no_telp,
                'email_ortu' => $row->email_ortu ?? null,
                'pendidikan_ortu' => $row->pendidikan,
                'gaji_ortu' => $row->gaji,
                'alamat_ortu' => $row->alamat_ortu,

                'berkas' => $berkasMap,

                'approve_url' => route('admin.pendaftaran.approve', $row->pendaftaran_uid),
                'reject_url' => route('admin.pendaftaran.reject', $row->pendaftaran_uid),
                'invoice_url' => route('admin.pendaftaran.invoice', $row->pendaftaran_uid),
            ];
        })->values();
        $batch = DB::table('batch_pendaftaran')
            ->orderByDesc('uid')
            ->first();
        $jumlahPerBatch = DB::table('pendaftaran')
            ->select('id_batch_pendaftaran', DB::raw('COUNT(*) as total_pendaftar'))
            ->groupBy('id_batch_pendaftaran');

        $batchList = DB::table('batch_pendaftaran as b')
            ->leftJoinSub($jumlahPerBatch, 'j', function ($join) {
                $join->on('j.id_batch_pendaftaran', '=', 'b.uid');
            })
            ->select(
                'b.uid',
                'b.nama_batch',
                'b.tanggal_buka',
                'b.tanggal_tutup',
                'b.kuota',
                'b.is_active',
                DB::raw('COALESCE(j.total_pendaftar, 0) as total_pendaftar'),
                DB::raw('GREATEST(b.kuota - COALESCE(j.total_pendaftar, 0), 0) as sisa_kuota')
            )
            ->orderBy('b.uid')
            ->get();

        $riwayatSiswa = $this->getRiwayatVerifikasiAdmin();

        return view('dashboard_admin.admin', compact(
            'dataSiswa',
            'batch',
            'batchList',
            'riwayatSiswa'
        ));
    }
    private function getRiwayatVerifikasiAdmin()
    {
        $select = [
            'pendaftaran.uid as pendaftaran_uid',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.alasan_penolakan',
            'pendaftaran.tanggal_daftar',
            'pendaftaran.id_batch_pendaftaran',
            'pendaftaran.diverifikasi_oleh',
            'pendaftaran.jenis_penolakan',

            'calon_siswa.uid as calon_siswa_uid',
            'calon_siswa.nama',
            'calon_siswa.nik',
            'calon_siswa.nomor_registrasi',

            'orang_tua.nama as nama_ortu',

            'batch_pendaftaran.nama_batch',

            'tagihan.nomor_tagihan',
            'tagihan.total_tagihan',
            'tagihan.status_tagihan',
            'tagihan.tanggal_tagihan',
        ];

        if (Schema::hasColumn('pendaftaran', 'tanggal_verifikasi')) {
            $select[] = 'pendaftaran.tanggal_verifikasi';
        } else {
            $select[] = DB::raw('NULL as tanggal_verifikasi');
        }

        if (Schema::hasColumn('pendaftaran', 'updated_at')) {
            $select[] = 'pendaftaran.updated_at as pendaftaran_updated_at';
        } else {
            $select[] = DB::raw('NULL as pendaftaran_updated_at');
        }

        return DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->leftJoin('batch_pendaftaran', 'batch_pendaftaran.uid', '=', 'pendaftaran.id_batch_pendaftaran')
            ->leftJoin('tagihan', 'tagihan.uid_pendaftaran', '=', 'pendaftaran.uid')
            ->select($select)
            ->orderByDesc('pendaftaran.uid')
            ->get()
            ->map(function ($row) {
                $status = $row->status_pendaftaran ?? 'proses';

                $statusAdmin = match ($status) {
                    'approved' => 'approved',
                    'rejected' => 'rejected',
                    'draft' => 'draft',
                    default => 'proses',
                };

                $tanggalVerifikasi = $row->tanggal_verifikasi ?? null;

                if (!$tanggalVerifikasi && in_array($statusAdmin, ['approved', 'rejected'], true)) {
                    $tanggalVerifikasi = $row->pendaftaran_updated_at ?? null;
                }

                return [
                    'pendaftaran_uid' => $row->pendaftaran_uid,
                    'id' => $row->no_pendaftaran ?? $row->nomor_registrasi ?? 'REG-' . $row->pendaftaran_uid,
                    'nama' => $row->nama ?? '-',
                    'nik' => $row->nik ?? '-',
                    'nama_ortu' => $row->nama_ortu ?? '-',
                    'status' => $statusAdmin,
                    'status_label' => strtoupper($statusAdmin),
                    'tanggal_submit' => $row->tanggal_daftar,
                    'tanggal_verifikasi' => $tanggalVerifikasi,
                    'diverifikasi_oleh' => $row->diverifikasi_oleh ?? '-',
                    'alasan_penolakan' => $row->alasan_penolakan ?? '-',
                    'jenis_penolakan' => $row->jenis_penolakan ?? '-',
                    'id_batch_pendaftaran' => $row->id_batch_pendaftaran,
                    'nama_batch' => $row->nama_batch ?? 'Tanpa Batch',
                    'nomor_tagihan' => $row->nomor_tagihan ?? '-',
                    'total_tagihan' => (float) ($row->total_tagihan ?? 0),
                    'status_tagihan' => $row->status_tagihan ?? '-',
                    'tanggal_tagihan' => $row->tanggal_tagihan ?? null,
                    'invoice_url' => $statusAdmin === 'approved'
                        ? route('admin.pendaftaran.invoice', $row->pendaftaran_uid)
                        : null,
                ];
            })
            ->values();
    }

    public function approve($uid)
    {
        $this->checkAdmin();

        $pendaftaran = DB::table('pendaftaran')
            ->where('uid', $uid)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.',
            ], 404);
        }

        $verifiedAt = now();
        $verifiedBy = session('email') ?? 'Admin';

        DB::transaction(function () use ($pendaftaran, $uid, $verifiedAt, $verifiedBy) {
            $pendaftaranUpdate = [
                'status_pendaftaran' => 'approved',
                'alasan_penolakan' => null,
                'diverifikasi_oleh' => $verifiedBy,
            ];

            if (Schema::hasColumn('pendaftaran', 'tanggal_verifikasi')) {
                $pendaftaranUpdate['tanggal_verifikasi'] = $verifiedAt;
            }

            DB::table('pendaftaran')
                ->where('uid', $uid)
                ->update($pendaftaranUpdate);

            DB::table('calon_siswa')
                ->where('uid', $pendaftaran->calon_siswa_id)
                ->update([
                    'status' => 'approved',
                ]);

            DB::table('berkas')
                ->where('id_pendaftar', $uid)
                ->update([
                    'is_valid' => 1,
                ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pendaftar berhasil diloloskan.',
            'invoice_url' => route('admin.pendaftaran.invoice', $uid),
            'tanggal_verifikasi' => $verifiedAt->toDateTimeString(),
            'diverifikasi_oleh' => $verifiedBy,
        ]);
    }

    public function reject(Request $request, $uid)
    {
        $this->checkAdmin();

        $request->validate([
            'alasan' => 'required|string|min:5|max:255',
            'invalid_berkas' => 'nullable|array',
            'invalid_berkas.*' => 'string',
        ]);

        $pendaftaran = DB::table('pendaftaran')
            ->where('uid', $uid)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.',
            ], 404);
        }

        $invalidBerkas = $request->invalid_berkas ?? [];
        $verifiedAt = now();
        $verifiedBy = session('email') ?? 'Admin';

        DB::transaction(function () use ($request, $pendaftaran, $uid, $invalidBerkas, $verifiedAt, $verifiedBy) {
            $pendaftaranUpdate = [
                'status_pendaftaran' => 'rejected',
                'jenis_penolakan' => $request->jenis_penolakan ?? 'berkas',
                'alasan_penolakan' => $request->alasan,
                'diverifikasi_oleh' => $verifiedBy,
            ];

            if (Schema::hasColumn('pendaftaran', 'tanggal_verifikasi')) {
                $pendaftaranUpdate['tanggal_verifikasi'] = $verifiedAt;
            }

            DB::table('pendaftaran')
                ->where('uid', $uid)
                ->update($pendaftaranUpdate);

            DB::table('calon_siswa')
                ->where('uid', $pendaftaran->calon_siswa_id)
                ->update([
                    'status' => 'rejected',
                ]);

            DB::table('berkas')
                ->where('id_pendaftar', $uid)
                ->update([
                    'is_valid' => 1,
                ]);

            if (!empty($invalidBerkas)) {
                DB::table('berkas')
                    ->where('id_pendaftar', $uid)
                    ->whereIn('jenis_berkas', $invalidBerkas)
                    ->update([
                        'is_valid' => 0,
                    ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Pendaftar berhasil ditolak.',
            'tanggal_verifikasi' => $verifiedAt->toDateTimeString(),
            'diverifikasi_oleh' => $verifiedBy,
        ]);
    }

    public function invoice($uid)
    {
        $this->checkAdmin();

        $pendaftaran = DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->where('pendaftaran.uid', $uid)
            ->select(
                'pendaftaran.uid',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.tanggal_daftar',
                'pendaftaran.diverifikasi_oleh',

                'calon_siswa.uid as calon_siswa_uid',
                'calon_siswa.nama as nama_siswa',
                'calon_siswa.nik',

                'orang_tua.nama as nama_ortu'
            )
            ->first();

        if (!$pendaftaran) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }

        if ($pendaftaran->status_pendaftaran !== 'approved') {
            abort(403, 'Invoice hanya tersedia setelah pendaftar diloloskan.');
        }

        $tagihan = DB::table('tagihan')
            ->where('uid_pendaftaran', $uid)
            ->first();

        $komponenTagihan = collect();
        $invoiceFinal = false;

        if ($tagihan) {
            $invoiceFinal = in_array(strtolower((string) $tagihan->status_tagihan), ['valid', 'terbit', 'approved'], true)
                && (!Schema::hasColumn('tagihan', 'disetujui_oleh') || !empty($tagihan->disetujui_oleh));

            $komponenTagihan = DB::table('komponen_tagihan')
                ->where('uid_tagihan', $tagihan->uid)
                ->orderBy('urutan')
                ->get();
        }

        return view('dashboard_admin.invoice', compact(
            'pendaftaran',
            'tagihan',
            'komponenTagihan',
            'invoiceFinal'
        ));
    }

    public function saveTagihan(Request $request, $uid)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'diskon' => 'nullable|numeric|min:0',
            'admin_pembuat' => 'required|string|max:255',
            'status_tagihan' => 'nullable|in:pending',
            'items' => 'required|array|min:1',
            'items.*.nama_komponen' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.nominal' => 'required|numeric|min:0',
        ]);

        $pendaftaran = DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->where('pendaftaran.uid', $uid)
            ->select(
                'pendaftaran.uid',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.status_pendaftaran',
                'calon_siswa.uid as calon_siswa_uid',
                'calon_siswa.nama as nama_siswa'
            )
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.',
            ], 404);
        }

        if ($pendaftaran->status_pendaftaran !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan hanya bisa dibuat untuk pendaftar yang sudah approved.',
            ], 403);
        }

        $existingFinalTagihanQuery = DB::table('tagihan')
            ->where('uid_pendaftaran', $uid)
            ->whereIn('status_tagihan', ['valid', 'terbit', 'approved']);

        if (Schema::hasColumn('tagihan', 'disetujui_oleh')) {
            $existingFinalTagihanQuery->whereNotNull('disetujui_oleh')
                ->where('disetujui_oleh', '<>', '');
        }

        $existingFinalTagihan = $existingFinalTagihanQuery->first();

        if ($existingFinalTagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice sudah menjadi final approval kepala sekolah. Admin SPMB tidak dapat mengubah invoice ini lagi.',
            ], 403);
        }

        $subtotalTagihan = 0;

        foreach ($validated['items'] as $item) {
            $qty = (float) $item['qty'];
            $nominal = (float) $item['nominal'];

            $subtotalTagihan += $qty * $nominal;
        }

        $diskon = (float) ($validated['diskon'] ?? 0);
        $totalTagihan = max(0, $subtotalTagihan - $diskon);

        $tagihanId = DB::transaction(function () use ($uid, $validated, $subtotalTagihan, $diskon, $totalTagihan) {
            $existingTagihan = DB::table('tagihan')
                ->where('uid_pendaftaran', $uid)
                ->first();

            $nomorTagihan = 'INV-' . now()->format('Ymd') . '-' . str_pad($uid, 5, '0', STR_PAD_LEFT);

            $dataTagihan = [
                'uid_pendaftaran' => $uid,
                'nomor_tagihan' => $nomorTagihan,
                'subtotal_tagihan' => $subtotalTagihan,
                'diskon_tagihan' => $diskon,
                'total_tagihan' => $totalTagihan,
                // Admin hanya boleh mengirim draft invoice ke antrian kepala sekolah.
                // Status final/terbit hanya boleh ditetapkan dari dashboard kepala sekolah.
                'status_tagihan' => 'pending',
                'tanggal_tagihan' => now(),
                'dibuat_oleh' => $validated['admin_pembuat'],
                'updated_at' => now(),
            ];

            if ($existingTagihan) {
                DB::table('tagihan')
                    ->where('uid', $existingTagihan->uid)
                    ->update($dataTagihan);

                $tagihanId = $existingTagihan->uid;

                DB::table('komponen_tagihan')
                    ->where('uid_tagihan', $tagihanId)
                    ->delete();
            } else {
                $dataTagihan['created_at'] = now();

                $tagihanId = DB::table('tagihan')
                    ->insertGetId($dataTagihan);
            }

            foreach ($validated['items'] as $index => $item) {
                $qty = (float) $item['qty'];
                $nominal = (float) $item['nominal'];
                $subtotal = $qty * $nominal;

                DB::table('komponen_tagihan')->insert([
                    'uid_tagihan' => $tagihanId,
                    'nama_komponen' => $item['nama_komponen'],
                    'qty' => $qty,
                    'nominal' => $nominal,
                    'subtotal' => $subtotal,
                    'urutan' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $tagihanId;
        });

        return response()->json([
            'success' => true,
            'message' => 'Tagihan berhasil disimpan ke database.',
            'tagihan_id' => $tagihanId,
        ]);

    }

    public function showVerifikasi($uid)
    {
        $this->checkAdmin();

        $pendaftaran = DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->where('pendaftaran.uid', $uid)
            ->select(
                'pendaftaran.uid as pendaftaran_uid',
                'pendaftaran.no_pendaftaran',
                'pendaftaran.tanggal_daftar',

                'calon_siswa.uid as calon_siswa_uid',
                'calon_siswa.nama',
                'calon_siswa.nik',
                'calon_siswa.tanggal_lahir',
                'calon_siswa.tempat_lahir',
                'calon_siswa.alamat',
                'calon_siswa.agama',
                'calon_siswa.golongan_darah',
                'calon_siswa.nomor_registrasi',

                'orang_tua.nama as nama_ortu',
                'orang_tua.no_telp',
                'orang_tua.pendidikan',
                'orang_tua.gaji',
                'orang_tua.alamat as alamat_ortu'
            )
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftaran tidak ditemukan.'
            ], 404);
        }

        $berkasSiswa = DB::table('berkas')
            ->where('id_pendaftar', $uid)
            ->get();

        $berkasMap = $this->mapBerkas($berkasSiswa);

        return response()->json([
            'success' => true,
            'reg' => $pendaftaran->no_pendaftaran
                ?? $pendaftaran->nomor_registrasi
                ?? 'REG-' . $pendaftaran->pendaftaran_uid,

            'siswa' => [
                'nama_lengkap' => $pendaftaran->nama ?? '-',
                'nik' => $pendaftaran->nik ?? '-',
                'tanggal_lahir' => $pendaftaran->tanggal_lahir ?? '-',
                'tempat_lahir' => $pendaftaran->tempat_lahir ?? '-',
                'alamat' => $pendaftaran->alamat ?? '-',
                'agama' => $pendaftaran->agama ?? '-',
                'gol_darah' => $pendaftaran->golongan_darah ?? '-',
            ],

            'orang_tua' => [
                'nama' => $pendaftaran->nama_ortu ?? '-',
                'no_telp' => $pendaftaran->no_telp ?? '-',
                'pendidikan' => $pendaftaran->pendidikan ?? '-',
                'gaji' => $pendaftaran->gaji ?? '-',
                'alamat' => $pendaftaran->alamat_ortu ?? '-',
            ],

            'berkas' => $berkasMap,
        ]);
    }


}