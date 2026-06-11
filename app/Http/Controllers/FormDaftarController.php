<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormDaftarController extends Controller
{
    public function index()
    {
        $draft = DB::table('calon_siswa')
            ->where('uid_orangtua', session('uid_orangtua'))
            ->latest('uid')
            ->first();

        $orangTua = DB::table('orang_tua')
            ->where('uid', session('uid_orangtua'))
            ->first();

        $berkas = collect();

        if ($draft) {
            $berkas = DB::table('berkas')
                ->where('id_pendaftar', $draft->uid)
                ->get()
                ->keyBy('jenis_berkas');
        }

        return view('dashboard_user.form_daftar', compact('draft', 'berkas', 'orangTua'));
    }

    public function store(Request $request)
    {
        $uidCalonSiswa = DB::table('calon_siswa')->insertGetId([
            'nama' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'golongan_darah' => $request->gol_darah,
            'tempat_lahir' => $request->tempat_lahir,
            'uid_orangtua' => session('uid_orangtua'),
        ]);

        $files = [
            'kartu_keluarga' => 'Kartu Keluarga',
            'akte_kelahiran' => 'Akte Kelahiran',
            'ktp_ortu' => 'E-KTP Orang Tua',
            'pas_foto' => 'Pas Foto',
            'surat_baptis' => 'Surat Baptis',
        ];

        foreach ($files as $inputName => $jenisBerkas) {
            if ($request->hasFile($inputName)) {
                $path = $request->file($inputName)->store('berkas', 'public');

                DB::table('berkas')->insert([
                    'id_pendaftar' => $uidCalonSiswa,
                    'jenis_berkas' => $jenisBerkas,
                    'file_url' => $path,
                    'is_valid' => 0,
                ]);
            }
        }

        return redirect()->route('form.daftar')
            ->with('success', 'Data siswa berhasil disimpan');
    }

    public function saveDraft(Request $request)
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

        return response()->json([
            'success' => true
        ]);
    }
}