<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormOrtuController extends Controller
{
    public function index()
    {
        return view('dashboard_user.form_profilOrtu');
    }

    public function store(Request $request)
    {
        DB::table('orang_tua')->insert([
            'nama' => $request->nama ?? 'Orang Tua',
            'no_telp' => $request->no_telp ?? '-',
            'alamat' => $request->alamat,
            'gaji' => $request->penghasilan,
        ]);

        return redirect()->route('form.daftar');
    }
}