<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VerifikasiBerkasController extends Controller
{
    public function show($uid)
    {
        $uidOrangTua = session('uid_orangtua');

        $siswa = DB::table('calon_siswa')
            ->where('uid', $uid)
            ->where('uid_orangtua', $uidOrangTua)
            ->first();

        if (! $siswa) {
            abort(404, 'Data calon siswa tidak ditemukan.');
        }

        $berkas = DB::table('berkas')
            ->where('id_pendaftar', $uid)
            ->get();

        return view('dashboard_user.verifikasi_berkas', compact('siswa', 'berkas'));
    }
}
