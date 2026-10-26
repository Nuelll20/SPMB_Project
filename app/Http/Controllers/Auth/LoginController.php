<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Saat tombol dari landing page membuka login, jangan otomatis masuk ke dashboard admin.
        // Session admin lama dibersihkan supaya halaman login tetap menjadi pintu masuk utama.
        if (in_array(session('role'), ['admin', 'kepsek'], true)) {
            session()->forget([
                'staff_login',
                'login_id',
                'uid_user',
                'email',
                'role',
            ]);
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

        $email = Str::lower(trim($validated['email']));

        $staff = DB::table('user')
            ->where('email', $email)
            ->first();

        if (
            $staff
            && Hash::check(
                $validated['password'],
                $staff->hash_password
            )
        ) {
            $role = strtolower(trim((string) $staff->role));

            $role = in_array(
                $role,
                ['kepsek', 'kepala_sekolah', 'kepala sekolah'],
                true
            ) ? 'kepsek' : $role;

            if (!in_array($role, ['admin', 'kepsek'], true)) {
                return back()
                    ->withErrors([
                        'email' => 'Role akun tidak dikenali.',
                    ])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            $request->session()->put([
                'staff_login' => true,
                'login_id' => $staff->uid,
                'uid_user' => $staff->uid_user,
                'email' => $staff->email,
                'role' => $role,
            ]);

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('kepsek.dashboard');
        }

        $user = User::where('email', $email)->first();

        if (
            $user
            && Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            Auth::login($user);

            $request->session()->regenerate();

            $request->session()->put([
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