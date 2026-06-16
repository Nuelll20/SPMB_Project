<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    
    public function upload(Request $request)
    {
        $request->validate([
            'id_pendaftar' => 'required|integer',
            'jenis_berkas' => 'required|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('berkas', 'public');

        DB::table('berkas')->insert([
            'id_pendaftar' => $request->id_pendaftar,
            'jenis_berkas' => $request->jenis_berkas,
            'file_url' => $path,
            'is_valid' => 0,
        ]);

        return back()->with('success', 'Berkas berhasil diupload!');
    }


    public function validasi($id, $status)
    {
        DB::table('berkas')
            ->where('uid', $id)
            ->update(['is_valid' => $status]);

        return back()->with('success', 'Status berkas berhasil diupdate!');
    }

   
    public function index($id_pendaftar)
    {
        $berkas = DB::table('berkas')
            ->where('id_pendaftar', $id_pendaftar)
            ->get();

        return view('berkas.index', compact('berkas'));
    }
}