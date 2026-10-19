<?php

use App\Http\Controllers\Auth\FormOrtuController;
use App\Http\Controllers\DashboardOrtuController;
use App\Http\Controllers\FormDaftarController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\VerifikasiBerkasController;
use Illuminate\Support\Facades\Route;

// Semua halaman orang tua memerlukan autentikasi.
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