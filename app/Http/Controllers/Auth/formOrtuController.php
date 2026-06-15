<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FormOrtuController extends Controller
{
    public function index()
    {
        $orangTua = $this->findOrangTua();

        if ($orangTua) {
            session(['uid_orangtua' => $orangTua->uid]);
        }

        return view('dashboard_user.form_profilOrtu', compact('orangTua'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_telepon' => 'required|string|min:10|max:15',
            'alamat' => 'required|string|max:250',
            'penghasilan' => 'required|numeric|min:0',
            'pendidikan' => 'required|string|max:100',
            'unit_sekolah' => 'required|string|max:255',
            'jumlah_anak' => 'required|integer|min:1|max:5',
        ]);

        $data = [
            'nama' => Auth::user()->name,
            'no_telp' => $validated['nomor_telepon'],
            'alamat' => $validated['alamat'],
            'gaji' => $validated['penghasilan'],
            'pendidikan' => $validated['pendidikan'],
            'unit_sekolah' => $validated['unit_sekolah'],
            'jumlah_anak' => $validated['jumlah_anak'],
        ];

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            $data['user_id'] = Auth::id();
        }

        $orangTua = $this->findOrangTua();

        if ($orangTua) {
            DB::table('orang_tua')->where('uid', $orangTua->uid)->update($data);
            $uidOrangTua = $orangTua->uid;
        } else {
            $uidOrangTua = DB::table('orang_tua')->insertGetId($data);
        }

        session(['uid_orangtua' => $uidOrangTua]);

        return redirect()->route('form.daftar')->with('success', 'Profil orang tua berhasil disimpan.');
    }

    private function findOrangTua()
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        if (session()->has('uid_orangtua')) {
            $bySession = DB::table('orang_tua')->where('uid', session('uid_orangtua'))->first();
            if ($bySession) {
                return $bySession;
            }
        }

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            return DB::table('orang_tua')->where('user_id', $user->id)->first();
        }

        return DB::table('orang_tua')->where('nama', $user->name)->first();
    }
}
