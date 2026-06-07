<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('dashboard_user.form_daftar');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/forgot-password', function () {
    return view('auth.forgot_pass');
})->name('password.request');

Route::post('/forgot-password', function () {
    return "Fitur send email/proses reset password belum didefinisikan.";
})->name('password.email');

Route::get('/profil-ortu', function () {
    return view('dashboard_user.form_profilOrtu');
})->name('profil.ortu');

Route::post('/profil-ortu', function (Request $request) {
    DB::table('orang_tua')->insert([
        'nama' => $request->nama ?? 'Orang Tua',
        'no_telp' => $request->no_telp ?? '-',
        'alamat' => $request->alamat,
        'gaji' => $request->penghasilan,
    ]);

    return redirect()->route('form.daftar');
})->name('profil.ortu.store');

Route::get('/form-daftar', function () {
    return view('dashboard_user.form_daftar');
})->name('form.daftar');