<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Email atau password yang kamu masukkan salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $orangTua = $this->findOrangTuaForCurrentUser();

        if ($orangTua) {
            session(['uid_orangtua' => $orangTua->uid]);
            return redirect()->route('dashboard');
        }

        return redirect()->route('profil.ortu');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function findOrangTuaForCurrentUser()
    {
        $user = Auth::user();

        if (! $user) {
            return null;
        }

        $query = DB::table('orang_tua');

        // Jika kolom user_id sudah ditambahkan, pakai relasi yang paling aman.
        if (Schema::hasColumn('orang_tua', 'user_id')) {
            return $query->where('user_id', $user->id)->first();
        }

        // Fallback agar tetap cocok dengan struktur database lama Anda.
        return $query->where('nama', $user->name)->first();
    }
}