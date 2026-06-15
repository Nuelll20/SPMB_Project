<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (session('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 1. Cek akun staff: admin / kepsek
        |--------------------------------------------------------------------------
        | Tabel: user
        | Kolom: email, hash_password, role
        */
        $staff = DB::table('user')
            ->where('email', $validated['email'])
            ->first();

        if ($staff && Hash::check($validated['password'], $staff->hash_password)) {
            session([
                'staff_login' => true,
                'login_id' => $staff->uid,
                'uid_user' => $staff->uid_user,
                'email' => $staff->email,
                'role' => $staff->role,
            ]);

            if ($staff->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($staff->role === 'kepsek') {
                return redirect()->route('login')->withErrors([
                    'email' => 'Dashboard kepsek belum dibuat.',
                ]);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Role tidak dikenali.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Cek akun orang tua / user biasa
        |--------------------------------------------------------------------------
        | Tabel: users
        | Kolom: email, password
        */
        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);

            $request->session()->regenerate();

            session([
                'role' => 'user',
                'email' => $user->email,
            ]);

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            Auth::logout();
        }

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}