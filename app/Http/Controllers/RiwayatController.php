<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RiwayatController extends Controller
{
    public function index()
    {
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        $dataSiswa = DB::table('calon_siswa')
            ->leftJoin('pendaftaran', 'pendaftaran.calon_siswa_id', '=', 'calon_siswa.uid')
            ->where('calon_siswa.uid_orangtua', $orangTua->uid)
            ->select(
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
                'pendaftaran.tanggal_daftar'
            )
            ->orderByDesc('calon_siswa.uid')
            ->get()
            ->map(function ($siswa) {
                $siswa->status = $siswa->status_pendaftaran ?? $siswa->status ?? 'pending';
                $siswa->nomor_registrasi = $siswa->nomor_registrasi ?? $siswa->no_pendaftaran ?? '-';

                return $siswa;
            });

        return view('dashboard_user.riwayat', compact('dataSiswa'));
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