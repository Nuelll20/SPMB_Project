<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\FormOrtuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardOrtuController;
use App\Http\Controllers\FormDaftarController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\VerifikasiBerkasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session('role') === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


// ===================== LOGIN / REGISTER =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/forgot-password', function () {
        return view('auth.forgot_pass');
    })->name('password.request');

    Route::post('/forgot-password', function () {
        return 'Fitur send email/proses reset password belum didefinisikan.';
    })->name('password.email');
});


// ===================== LOGOUT =====================
// Logout wajib di luar middleware auth karena admin login pakai session
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


// ===================== ADMIN ROUTES =====================
// Jangan masukkan ke middleware auth karena admin login pakai session('role')
Route::get('/dashboard-admin', [AdminController::class, 'index'])
    ->name('admin.dashboard');

Route::post('/admin/pendaftaran/{uid}/approve', [AdminController::class, 'approve'])
    ->name('admin.pendaftaran.approve');

Route::post('/admin/pendaftaran/{uid}/reject', [AdminController::class, 'reject'])
    ->name('admin.pendaftaran.reject');

Route::get('/admin/pendaftaran/{uid}/invoice', [AdminController::class, 'invoice'])
    ->name('admin.pendaftaran.invoice');

Route::post('/admin/pendaftaran/{uid}/tagihan/save', [AdminController::class, 'saveTagihan'])
    ->name('admin.pendaftaran.tagihan.save');


// ===================== ORANG TUA / USER ROUTES =====================
// Ini khusus akun orang tua dari tabel users
Route::middleware('auth')->group(function () {
    Route::get('/profil-ortu', [FormOrtuController::class, 'index'])
        ->name('profil.ortu');

    Route::post('/profil-ortu', [FormOrtuController::class, 'store'])
        ->name('profil.ortu.store');

    Route::get('/form-daftar', [FormDaftarController::class, 'index'])
        ->name('form.daftar');

    Route::post('/form-daftar', [FormDaftarController::class, 'store'])
        ->name('form.daftar.store');

    Route::post('/form-daftar/draft', [FormDaftarController::class, 'saveDraft'])
        ->name('form.daftar.draft');

    Route::get('/dashboard_ortu', [DashboardOrtuController::class, 'index'])
        ->name('dashboard');

    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');

    Route::get('/pusat-bantuan', function () {
        return view('dashboard_user.pusat_bantuan');
    })->name('pusat_bantuan');

    Route::get('/verifikasi-berkas/{uid}', [VerifikasiBerkasController::class, 'show'])
        ->name('verifikasi.berkas');
});

Route::get('/admin/verifikasi-berkas/{uid}', [AdminController::class, 'showVerifikasi'])
    ->name('admin.verifikasi.show');

Route::post('/admin/batch/save', [AdminController::class, 'saveBatch'])
    ->name('admin.batch.save');

    Route::post('/admin/batch/save', [AdminController::class, 'saveBatch'])
    ->name('admin.batch.save');

    Route::delete('/admin/batch/{uid}', [AdminController::class, 'deleteBatch'])
    ->name('admin.batch.delete');