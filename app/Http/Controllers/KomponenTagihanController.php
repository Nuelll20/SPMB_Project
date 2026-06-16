<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomponenTagihanController extends Controller
{
    public function index($uid_tagihan)
    {
        $komponenTagihan = DB::table('komponen_tagihan')
            ->where('uid_tagihan', $uid_tagihan)
            ->orderBy('uid')
            ->get();

        $tagihan = DB::table('tagihan')
            ->where('uid', $uid_tagihan)
            ->first();

        return view('komponen_tagihan.index', compact('komponenTagihan', 'tagihan'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'uid_tagihan'    => 'required|integer',
            'nama_komponen'  => 'required|string|max:255',
            'nominal'        => 'required|numeric|min:0',
        ]);

        DB::table('komponen_tagihan')->insert([
            'uid_tagihan'   => $request->uid_tagihan,
            'nama_komponen' => $request->nama_komponen,
            'nominal'       => $request->nominal,
        ]);

        return back()->with('success', 'Komponen tagihan berhasil ditambahkan!');
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'nominal'       => 'required|numeric|min:0',
        ]);

        DB::table('komponen_tagihan')
            ->where('uid', $id)
            ->update([
                'nama_komponen' => $request->nama_komponen,
                'nominal'       => $request->nominal,
            ]);

        return back()->with('success', 'Komponen tagihan berhasil diupdate!');
    }

   
    public function destroy($id)
    {
        DB::table('komponen_tagihan')
            ->where('uid', $id)
            ->delete();

        return back()->with('success', 'Komponen tagihan berhasil dihapus!');
    }
}