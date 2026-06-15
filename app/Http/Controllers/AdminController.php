<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (session('role') !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $this->checkAdmin();

        $pendaftar = DB::table('pendaftaran')
            ->join('calon_siswa', 'calon_siswa.uid', '=', 'pendaftaran.calon_siswa_id')
            ->leftJoin('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
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
                'orang_tua.alamat as alamat_ortu'
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

            $berkasMap = [
                'kartu_keluarga' => '',
                'akte_kelahiran' => '',
                'ktp_orang_tua' => '',
                'pas_foto' => '',
                'surat_baptis' => '',
            ];

            foreach ($berkasSiswa as $item) {
                $url = asset('storage/' . $item->file_url);

                if ($item->jenis_berkas === 'Kartu Keluarga') {
                    $berkasMap['kartu_keluarga'] = $url;
                }

                if ($item->jenis_berkas === 'Akte Kelahiran') {
                    $berkasMap['akte_kelahiran'] = $url;
                }

                if ($item->jenis_berkas === 'E-KTP Orang Tua') {
                    $berkasMap['ktp_orang_tua'] = $url;
                }

                if ($item->jenis_berkas === 'Pas Foto') {
                    $berkasMap['pas_foto'] = $url;
                }

                if ($item->jenis_berkas === 'Surat Baptis') {
                    $berkasMap['surat_baptis'] = $url;
                }
            }

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
                'pendidikan_ortu' => $row->pendidikan,
                'gaji_ortu' => $row->gaji,
                'alamat_ortu' => $row->alamat_ortu,

                'berkas' => $berkasMap,

                'approve_url' => route('admin.pendaftaran.approve', $row->pendaftaran_uid),
                'reject_url' => route('admin.pendaftaran.reject', $row->pendaftaran_uid),
                'invoice_url' => route('admin.pendaftaran.invoice', $row->pendaftaran_uid),
            ];
        })->values();

        return view('dashboard_admin.admin', compact('dataSiswa'));
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

        DB::transaction(function () use ($pendaftaran, $uid) {
            DB::table('pendaftaran')
                ->where('uid', $uid)
                ->update([
                    'status_pendaftaran' => 'approved',
                    'alasan_penolakan' => null,
                    'diverifikasi_oleh' => session('email'),
                ]);

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
        ]);
    }

    public function reject(Request $request, $uid)
    {
        $this->checkAdmin();

        $request->validate([
            'alasan' => 'required|string|min:5|max:255',
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

        DB::transaction(function () use ($request, $pendaftaran, $uid) {
            DB::table('pendaftaran')
                ->where('uid', $uid)
                ->update([
                    'status_pendaftaran' => 'rejected',
                    'alasan_penolakan' => $request->alasan,
                    'diverifikasi_oleh' => session('email'),
                ]);

            DB::table('calon_siswa')
                ->where('uid', $pendaftaran->calon_siswa_id)
                ->update([
                    'status' => 'rejected',
                ]);

            DB::table('berkas')
                ->where('id_pendaftar', $uid)
                ->update([
                    'is_valid' => 0,
                ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pendaftar berhasil ditolak.',
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

        if ($tagihan) {
            $komponenTagihan = DB::table('komponen_tagihan')
                ->where('uid_tagihan', $tagihan->uid)
                ->orderBy('urutan')
                ->get();
        }

        return view('dashboard_admin.invoice', compact(
            'pendaftaran',
            'tagihan',
            'komponenTagihan'
        ));
    }

    public function saveTagihan(Request $request, $uid)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'diskon' => 'nullable|numeric|min:0',
            'admin_pembuat' => 'required|string|max:255',
            'status_tagihan' => 'required|in:pending,valid',
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
                'status_tagihan' => $validated['status_tagihan'],
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
}