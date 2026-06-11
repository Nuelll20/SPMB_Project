<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormDaftarController extends Controller
{
    public function index()
    {
        return view('dashboard_user.form_daftar');
    }

    public function store(Request $request)
    {
        DB::table('calon_siswa')->insert([
            'nama' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'golongan_darah' => $request->gol_darah,
            'tempat_lahir' => $request->tempat_lahir,
            'uid_orangtua' => session('uid_orangtua'),
        ]);

        return redirect()->route('form.daftar')
            ->with('success', 'Data siswa berhasil disimpan');
    }
}