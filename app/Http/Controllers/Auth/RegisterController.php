<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                function (string $attribute, mixed $value, Closure $fail): void {
                    $email = Str::lower(
                        trim((string) $value)
                    );

                    if (
                        DB::table('user')
                            ->where('email', $email)
                            ->exists()
                    ) {
                        $fail(
                            'Email tersebut sudah digunakan oleh akun staf.'
                        );
                    }
                },
            ],
            'password' => 'required|min:8|confirmed',
        ]);

        $email = Str::lower(
            trim($request->email)
        );

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }
}