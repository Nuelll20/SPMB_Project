<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\FormOrtuController;
use App\Http\Controllers\FormDaftarController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
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

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/dashboard_ortu', function () {
    return view('dashboard_user.dashboard_ortu');
})->name('dashboard');


Route::get('/profil-ortu', [FormOrtuController::class, 'index'])->name('profil.ortu');
Route::post('/profil-ortu', [FormOrtuController::class, 'store'])->name('profil.ortu.store');


Route::get('/form-daftar', [FormDaftarController::class, 'index'])
    ->name('form.daftar');

Route::post('/form-daftar', [FormDaftarController::class, 'store'])
    ->name('form.daftar.store');

Route::post('/form-daftar/draft',
    [FormDaftarController::class, 'saveDraft'])
    ->name('form.daftar.draft');

Route::get('/riwayat', function () {
    return view('dashboard_user.riwayat');
})->name('riwayat');

Route::get('/pusat-bantuan', function () {
    return view('dashboard_user.bantuan');
})->name('pusat-bantuan');

