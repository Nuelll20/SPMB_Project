<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormOrtuController extends Controller
{
    public function index()
    {
        return view('dashboard_user.form_profilOrtu');
    }

    public function store(Request $request)
    {
        $uidOrangTua = DB::table('orang_tua')->insertGetId([
            'nama' => $request->nama ?? Auth::user()->name,
            'no_telp' => $request->no_telp ?? '-',
            'alamat' => $request->alamat,
            'gaji' => $request->penghasilan,
        ]);

        session(['uid_orangtua' => $uidOrangTua]);

        return redirect()->route('form.daftar');
    }
}