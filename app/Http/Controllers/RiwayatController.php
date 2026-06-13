<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $dataSiswa = DB::table('calon_siswa')
            ->where('uid_orangtua', session('uid_orangtua'))
            ->get();

        return view('dashboard_user.riwayat', compact('dataSiswa'));
    }
}