<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
       
        return view('auth.login'); 
    }

    /**
     * Memproses data inputan dari form login.
     */
    public function login(Request $request)
    {
        // 1. Validasi inputan email dan password dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah user mencentang pilihan "Remember Me"
        $remember = $request->has('remember');

        // 3. Proses autentikasi (mencocokkan ke database)
        if (Auth::attempt($credentials, $remember)) {
            // Jika sukses, buat ulang session biar aman
            $request->session()->regenerate();

            // Alihkan user ke halaman utama (misal: dashboard)
            return redirect()->route('profil.ortu'); 
        }

        // 4. Jika gagal login, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email'); // Email tidak hilang dari inputan biar ga capek ngetik ulang
    }

    /**
     * Memproses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}