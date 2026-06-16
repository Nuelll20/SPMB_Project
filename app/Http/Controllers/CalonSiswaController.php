<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalonSiswaController extends Controller
{
    // Lihat semua data calon siswa
    public function index()
    {
        $calonSiswa = DB::table('calon_siswa')
            ->join('orang_tua', 'orang_tua.uid', '=', 'calon_siswa.uid_orangtua')
            ->select(
                'calon_siswa.*',
                'orang_tua.nama as nama_ortu',
                'orang_tua.no_telp'
            )
            ->orderByDesc('calon_siswa.uid')
            ->get();

        return view('calon_siswa.index', compact('calonSiswa'));
    }

    // Simpan data calon siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'nik'            => 'required|string|size:16|unique:calon_siswa,nik',
            'alamat'         => 'required|string|max:250',
            'agama'          => 'required|string|max:50',
            'golongan_darah' => 'nullable|string|max:3',
            'uid_orangtua'   => 'required|integer',
        ]);

        DB::table('calon_siswa')->insert([
            'nama'           => $request->nama,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'nik'            => $request->nik,
            'alamat'         => $request->alamat,
            'agama'          => $request->agama,
            'golongan_darah' => $request->golongan_darah,
            'uid_orangtua'   => $request->uid_orangtua,
        ]);

        return back()->with('success', 'Data calon siswa berhasil disimpan!');
    }

    // Update data calon siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string|max:250',
            'agama'          => 'required|string|max:50',
            'golongan_darah' => 'nullable|string|max:3',
        ]);

        DB::table('calon_siswa')
            ->where('uid', $id)
            ->update([
                'nama'           => $request->nama,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'alamat'         => $request->alamat,
                'agama'          => $request->agama,
                'golongan_darah' => $request->golongan_darah,
            ]);

        return back()->with('success', 'Data calon siswa berhasil diupdate!');
    }

    // Hapus data calon siswa
    public function destroy($id)
    {
        DB::table('calon_siswa')
            ->where('uid', $id)
            ->delete();

        return back()->with('success', 'Data calon siswa berhasil dihapus!');
    }
}