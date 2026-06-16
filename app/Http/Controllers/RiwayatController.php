<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        $hasTanggalVerifikasi = Schema::hasColumn('pendaftaran', 'tanggal_verifikasi');
        $hasPendaftaranUpdatedAt = Schema::hasColumn('pendaftaran', 'updated_at');
        $hasTagihan = Schema::hasTable('tagihan');

        $select = [
            'calon_siswa.uid',
            'calon_siswa.nama',
            'calon_siswa.nik',
            'calon_siswa.tanggal_lahir',
            'calon_siswa.tempat_lahir',
            'calon_siswa.agama',
            'calon_siswa.golongan_darah',
            'calon_siswa.alamat',
            'calon_siswa.status',
            'calon_siswa.nomor_registrasi',
            'calon_siswa.created_at',

            'pendaftaran.uid as pendaftaran_uid',
            'pendaftaran.no_pendaftaran',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.tanggal_daftar',
            'pendaftaran.id_batch_pendaftaran',

            'batch_pendaftaran.nama_batch',
            'batch_pendaftaran.tanggal_buka',
            'batch_pendaftaran.tanggal_tutup',
        ];

        $select[] = Schema::hasColumn('pendaftaran', 'alasan_penolakan')
            ? 'pendaftaran.alasan_penolakan'
            : DB::raw('NULL as alasan_penolakan');

        $select[] = Schema::hasColumn('pendaftaran', 'jenis_penolakan')
            ? 'pendaftaran.jenis_penolakan'
            : DB::raw('NULL as jenis_penolakan');

        $select[] = Schema::hasColumn('pendaftaran', 'diverifikasi_oleh')
            ? 'pendaftaran.diverifikasi_oleh'
            : DB::raw('NULL as diverifikasi_oleh');

        $select[] = $hasTanggalVerifikasi
            ? 'pendaftaran.tanggal_verifikasi'
            : DB::raw('NULL as tanggal_verifikasi');

        $select[] = $hasPendaftaranUpdatedAt
            ? 'pendaftaran.updated_at as pendaftaran_updated_at'
            : DB::raw('NULL as pendaftaran_updated_at');

        if ($hasTagihan) {
            $select = array_merge($select, [
                'tagihan.uid as tagihan_uid',
                'tagihan.nomor_tagihan',
                'tagihan.subtotal_tagihan',
                'tagihan.diskon_tagihan',
                'tagihan.total_tagihan',
                'tagihan.status_tagihan',
                'tagihan.tanggal_tagihan',
                'tagihan.dibuat_oleh as tagihan_dibuat_oleh',
            ]);
        } else {
            $select = array_merge($select, [
                DB::raw('NULL as tagihan_uid'),
                DB::raw('NULL as nomor_tagihan'),
                DB::raw('0 as subtotal_tagihan'),
                DB::raw('0 as diskon_tagihan'),
                DB::raw('0 as total_tagihan'),
                DB::raw('NULL as status_tagihan'),
                DB::raw('NULL as tanggal_tagihan'),
                DB::raw('NULL as tagihan_dibuat_oleh'),
            ]);
        }

        $query = DB::table('calon_siswa')
            ->leftJoin('pendaftaran', 'pendaftaran.calon_siswa_id', '=', 'calon_siswa.uid')
            ->leftJoin('batch_pendaftaran', 'batch_pendaftaran.uid', '=', 'pendaftaran.id_batch_pendaftaran')
            ->where('calon_siswa.uid_orangtua', $orangTua->uid);

        if ($hasTagihan) {
            $query->leftJoin('tagihan', 'tagihan.uid_pendaftaran', '=', 'pendaftaran.uid');
        }

        if ($request->filled('batch')) {
            $query->where('pendaftaran.id_batch_pendaftaran', $request->batch);
        }

        if ($request->filled('status')) {
            $query->where('pendaftaran.status_pendaftaran', $request->status);
        }

        if ($request->filled('q')) {
            $keyword = trim($request->q);

            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('calon_siswa.nama', 'like', '%' . $keyword . '%')
                    ->orWhere('calon_siswa.nik', 'like', '%' . $keyword . '%')
                    ->orWhere('calon_siswa.nomor_registrasi', 'like', '%' . $keyword . '%')
                    ->orWhere('pendaftaran.no_pendaftaran', 'like', '%' . $keyword . '%');
            });
        }

        $dataSiswa = $query
            ->select($select)
            ->orderByDesc('pendaftaran.uid')
            ->orderByDesc('calon_siswa.uid')
            ->get()
            ->map(function ($siswa) {
                $status = strtolower(trim($siswa->status_pendaftaran ?? $siswa->status ?? 'pending'));

                if (in_array($status, ['approved', 'accepted', 'diterima'])) {
                    $statusClass = 'status-approved';
                    $statusLabel = 'Approved';
                } elseif (in_array($status, ['rejected', 'ditolak'])) {
                    $statusClass = 'status-rejected';
                    $statusLabel = 'Rejected';
                } elseif ($status === 'draft') {
                    $statusClass = 'status-draft';
                    $statusLabel = 'Draft';
                } else {
                    $statusClass = 'status-pending';
                    $statusLabel = 'Proses';
                }

                $siswa->status_norm = $status;
                $siswa->status_class = $statusClass;
                $siswa->status_label = $statusLabel;
                $siswa->nomor_registrasi_final = $siswa->nomor_registrasi ?? $siswa->no_pendaftaran ?? '-';
                $siswa->nama_batch_final = $siswa->nama_batch ?? 'Tanpa Batch';
                $siswa->tanggal_submit_final = $siswa->tanggal_daftar ?? $siswa->created_at ?? null;
                $siswa->tanggal_verifikasi_final = $siswa->tanggal_verifikasi ?? null;
                $siswa->total_tagihan_final = (float) ($siswa->total_tagihan ?? 0);

                return $siswa;
            });

        $summary = [
            'total' => $dataSiswa->count(),
            'approved' => $dataSiswa->where('status_norm', 'approved')->count(),
            'rejected' => $dataSiswa->where('status_norm', 'rejected')->count(),
            'proses' => $dataSiswa->filter(fn ($item) => in_array($item->status_norm, ['pending', 'proses']))->count(),
            'total_tagihan' => $dataSiswa->where('status_norm', 'approved')->sum('total_tagihan_final'),
        ];

        $batchList = Schema::hasTable('batch_pendaftaran')
            ? DB::table('batch_pendaftaran')
                ->select('uid', 'nama_batch', 'tanggal_buka', 'tanggal_tutup')
                ->orderBy('uid')
                ->get()
            : collect();

        return view('dashboard_user.riwayat', compact('dataSiswa', 'summary', 'batchList'));
    }

    private function getOrangTua()
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        if (session()->has('uid_orangtua')) {
            $orangTua = DB::table('orang_tua')
                ->where('uid', session('uid_orangtua'))
                ->first();

            if ($orangTua) {
                return $orangTua;
            }
        }

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            return DB::table('orang_tua')
                ->where('user_id', $user->id)
                ->first();
        }

        return DB::table('orang_tua')
            ->where('nama', $user->name)
            ->first();
    }
}
