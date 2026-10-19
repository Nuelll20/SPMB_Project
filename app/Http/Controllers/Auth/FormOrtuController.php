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
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'pendidikan' => 'required|string|max:100',
            'penghasilan' => 'required|numeric',
            'nomor_telepon' => 'required|string|min:10|max:15',
            'unit_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string|min:5|max:250',
        ], [
            'pendidikan.required' => 'Pendidikan terakhir wajib dipilih.',
            'penghasilan.required' => 'Rentang penghasilan wajib dipilih.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.min' => 'Nomor telepon minimal 10 digit.',
            'nomor_telepon.max' => 'Nomor telepon maksimal 15 digit.',
            'unit_sekolah.required' => 'Unit sekolah tujuan wajib dipilih.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 5 karakter.',
        ]);

        $data = [
            'nama' => $user->name,
            'no_telp' => $validated['nomor_telepon'],
            'alamat' => $validated['alamat'],
            'gaji' => $validated['penghasilan'],
            'pendidikan' => $validated['pendidikan'],
            'unit_sekolah' => $validated['unit_sekolah'],
        ];

        if (Schema::hasColumn('orang_tua', 'updated_at')) {
            $data['updated_at'] = now();
        }

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            $orangTua = DB::table('orang_tua')
                ->where('user_id', $user->id)
                ->first();

            if ($orangTua) {
                DB::table('orang_tua')
                    ->where('uid', $orangTua->uid)
                    ->update($data);

                session(['uid_orangtua' => $orangTua->uid]);
            } else {
                $data['user_id'] = $user->id;

                if (Schema::hasColumn('orang_tua', 'created_at')) {
                    $data['created_at'] = now();
                }

                $uidOrangTua = DB::table('orang_tua')->insertGetId($data);

                session(['uid_orangtua' => $uidOrangTua]);
            }
        } else {
            $orangTua = DB::table('orang_tua')
                ->where('nama', $user->name)
                ->first();

            if ($orangTua) {
                DB::table('orang_tua')
                    ->where('uid', $orangTua->uid)
                    ->update($data);

                session(['uid_orangtua' => $orangTua->uid]);
            } else {
                if (Schema::hasColumn('orang_tua', 'created_at')) {
                    $data['created_at'] = now();
                }

                $uidOrangTua = DB::table('orang_tua')->insertGetId($data);

                session(['uid_orangtua' => $uidOrangTua]);
            }
        }

        return redirect()->route('form.daftar')
            ->with('success', 'Profil orang tua berhasil disimpan. Silakan lanjut mengisi data anak.');
    }

    private function findOrangTua()
    {
        $user = Auth::user();

        if (!$user) {
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
