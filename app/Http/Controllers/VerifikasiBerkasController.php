<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VerifikasiBerkasController extends Controller
{
    public function show($uid)
    {
        $siswa = DB::table('calon_siswa')
            ->where('uid', $uid)
            ->first();

        $berkas = DB::table('berkas')
            ->where('id_pendaftar', $uid)
            ->get();

        return view('dashboard_user.verifikasi_berkas', compact('siswa', 'berkas'));
    }
}