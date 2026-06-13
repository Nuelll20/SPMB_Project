<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardOrtuController extends Controller
{
    public function index()
    {
        $dataSiswa = DB::table('calon_siswa')
            ->where('uid_orangtua', session('uid_orangtua'))
            ->orderByDesc('uid')
            ->get();

        return view('dashboard_user.dashboard_ortu', compact('dataSiswa'));
    }
}