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
            'nama' => Auth::user()->name,
            'no_telp' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'gaji' => $request->penghasilan,
            'pendidikan' => $request->pendidikan,
            'unit_sekolah' => $request->unit_sekolah,
            'jumlah_anak' => $request->jumlah_anak ?? 1,
        ]);

        session(['uid_orangtua' => $uidOrangTua]);

        return redirect()->route('form.daftar');
    }
}