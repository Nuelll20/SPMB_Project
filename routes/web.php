<?php

use App\Http\Controllers\Auth\FormOrtuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardOrtuController;
use App\Http\Controllers\FormDaftarController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\VerifikasiBerkasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Auth guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', function () {
        return view('auth.forgot_pass');
    })->name('password.request');

    Route::post('/forgot-password', function () {
        return 'Fitur send email/proses reset password belum didefinisikan.';
    })->name('password.email');
});

// Parent/student workflow routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/profil-ortu', [FormOrtuController::class, 'index'])->name('profil.ortu');
    Route::post('/profil-ortu', [FormOrtuController::class, 'store'])->name('profil.ortu.store');

<<<<<<< HEAD
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
=======
    Route::get('/form-daftar', [FormDaftarController::class, 'index'])->name('form.daftar');
    Route::post('/form-daftar', [FormDaftarController::class, 'store'])->name('form.daftar.store');
    Route::post('/form-daftar/draft', [FormDaftarController::class, 'saveDraft'])->name('form.daftar.draft');
>>>>>>> 52228817466d328f73fde4276ee20cd2edaba1b1

    Route::get('/dashboard_ortu', [DashboardOrtuController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/pusat-bantuan', function () {
        return view('dashboard_user.pusat_bantuan');
    })->name('pusat_bantuan');

    Route::get('/verifikasi-berkas/{uid}', [VerifikasiBerkasController::class, 'show'])->name('verifikasi.berkas');
});

// Sementara belum diberi auth admin khusus
Route::get('/admin', function () {
    return view('dashboard_admin.admin');
})->name('admin');
<<<<<<< HEAD
Route::get('/invoice', function () {
    return view('dashboard_admin.invoice');
})->name('invoice');
=======
>>>>>>> 52228817466d328f73fde4276ee20cd2edaba1b1
