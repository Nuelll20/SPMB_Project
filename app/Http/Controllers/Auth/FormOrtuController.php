<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OrangTuaResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormOrtuController extends Controller
{
    public function __construct(
        private readonly OrangTuaResolver $orangTuaResolver
    ) {
    }

    public function index()
    {
        $orangTua = $this->orangTuaResolver->current();

        return view(
            'dashboard_user.form_profilOrtu',
            compact('orangTua')
        );
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

        $uidOrangTua = DB::transaction(
            function () use ($user, $data): int {
                $orangTua = DB::table('orang_tua')
                    ->where('user_id', $user->id)
                    ->orderByDesc('uid')
                    ->lockForUpdate()
                    ->first();

                if ($orangTua) {
                    DB::table('orang_tua')
                        ->where('uid', $orangTua->uid)
                        ->update($data);

                    return (int) $orangTua->uid;
                }

                return (int) DB::table('orang_tua')->insertGetId(
                    array_merge([
                        'user_id' => $user->id,
                    ], $data)
                );
            }
        );

        session([
            'uid_orangtua' => $uidOrangTua,
        ]);

        return redirect()
            ->route('form.daftar')
            ->with(
                'success',
                'Profil orang tua berhasil disimpan. Silakan lanjut mengisi data anak.'
            );
    }
}