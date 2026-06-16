<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchPendaftaranController extends Controller
{
    // Lihat semua data batch/kuota
    public function index()
    {
        $batches = DB::table('batch_pendaftaran')
            ->orderByDesc('uid')
            ->get();

        return view('batch_pendaftaran.index', compact('batches'));
    }

    // Tambah batch baru
    public function store(Request $request)
    {
        $request->validate([
            'cabang'     => 'required|string|max:255',
            'nama_batch' => 'required|string|max:255',
            'kuota'      => 'required|integer|min:1',
        ]);

        DB::table('batch_pendaftaran')->insert([
            'cabang'      => $request->cabang,
            'nama_batch'  => $request->nama_batch,
            'kuota'       => $request->kuota,
            'is_active'   => 1,
            'created_at'  => now(),
            'dibuat_oleh' => session('email'),
        ]);

        return back()->with('success', 'Batch pendaftaran berhasil ditambahkan!');
    }

    // Update kuota batch
    public function update(Request $request, $id)
    {
        $request->validate([
            'kuota' => 'required|integer|min:1',
        ]);

        DB::table('batch_pendaftaran')
            ->where('uid', $id)
            ->update(['kuota' => $request->kuota]);

        return back()->with('success', 'Kuota berhasil diupdate!');
    }

    // Nonaktifkan batch
    public function destroy($id)
    {
        DB::table('batch_pendaftaran')
            ->where('uid', $id)
            ->update(['is_active' => 0]);

        return back()->with('success', 'Batch berhasil dinonaktifkan!');
    }
}