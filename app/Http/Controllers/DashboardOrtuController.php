<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardOrtuController extends Controller
{
    public function index()
    {
        $orangTua = $this->getOrangTua();

        if (! $orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        session(['uid_orangtua' => $orangTua->uid]);

        $dataSiswa = DB::table('calon_siswa')
            ->where('uid_orangtua', $orangTua->uid)
            ->orderByDesc('uid')
            ->get();
$batch = DB::table('batch_pendaftaran')
    ->where('is_active', 1)
    ->orderByDesc('tanggal_buka')
    ->first();

$jumlahPendaftar = 0;
$sisaKuota = 0;
$batchAktif = false;

if ($batch) {
    $jumlahPendaftar = DB::table('pendaftaran')->count();

    $sisaKuota = max(0, (int) $batch->kuota - $jumlahPendaftar);
    $batchAktif = $sisaKuota > 0;
}

        return view('dashboard_user.dashboard_ortu', compact(
            'dataSiswa',
            'orangTua',
            'batch',
            'sisaKuota',
            'batchAktif'
        ));
    }

    private function getOrangTua()
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        if (session()->has('uid_orangtua')) {
            $orangTua = DB::table('orang_tua')->where('uid', session('uid_orangtua'))->first();
            if ($orangTua) {
                return $orangTua;
            }
        }

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            return DB::table('orang_tua')->where('user_id', $user->id)->first();
        }

        return DB::table('orang_tua')->where('nama', $user->name)->first();
    }
}