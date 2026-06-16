<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\FormOrtuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardOrtuController;
use App\Http\Controllers\FormDaftarController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\VerifikasiBerkasController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\BatchPendaftaranController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\KomponenTagihanController;
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
// Batch Pendaftaran
Route::get('/admin/batch', [BatchPendaftaranController::class, 'index'])->name('admin.batch.index');
Route::post('/admin/batch', [BatchPendaftaranController::class, 'store'])->name('admin.batch.store');
Route::put('/admin/batch/{id}', [BatchPendaftaranController::class, 'update'])->name('admin.batch.update');
Route::delete('/admin/batch/{id}', [BatchPendaftaranController::class, 'destroy'])->name('admin.batch.destroy');

// Komponen Tagihan
Route::get('/admin/komponen-tagihan/{uid_tagihan}', [KomponenTagihanController::class, 'index'])->name('admin.komponen.index');
Route::post('/admin/komponen-tagihan', [KomponenTagihanController::class, 'store'])->name('admin.komponen.store');
Route::put('/admin/komponen-tagihan/{id}', [KomponenTagihanController::class, 'update'])->name('admin.komponen.update');
Route::delete('/admin/komponen-tagihan/{id}', [KomponenTagihanController::class, 'destroy'])->name('admin.komponen.destroy');

// Berkas Admin
Route::post('/admin/berkas/validasi/{id}/{status}', [BerkasController::class, 'validasi'])->name('admin.berkas.validasi');


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
Route::get('/verifikasi-berkas/{uid}', [VerifikasiBerkasController::class, 'show'])
        ->name('verifikasi.berkas');

    // Berkas Orang Tua
    Route::post('/berkas/upload', [BerkasController::class, 'upload'])->name('berkas.upload');
    Route::get('/berkas/{id_pendaftar}', [BerkasController::class, 'index'])->name('berkas.index');

    // Calon Siswa
    Route::get('/calon-siswa', [CalonSiswaController::class, 'index'])->name('calon.siswa.index');
    Route::post('/calon-siswa', [CalonSiswaController::class, 'store'])->name('calon.siswa.store');
    Route::put('/calon-siswa/{id}', [CalonSiswaController::class, 'update'])->name('calon.siswa.update');
    Route::delete('/calon-siswa/{id}', [CalonSiswaController::class, 'destroy'])->name('calon.siswa.destroy');
});
