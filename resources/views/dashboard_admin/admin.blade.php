<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\BatchController;

/*
|--------------------------------------------------------------------------
| Web Routes – SAKTI PORTAL Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pendaftar (CRUD)
    Route::get('/pendaftar',                   [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar',                  [PendaftarController::class, 'store'])->name('pendaftar.store');
    Route::get('/pendaftar/{id}',              [PendaftarController::class, 'show'])->name('pendaftar.show');
    Route::patch('/pendaftar/{id}/approve',    [PendaftarController::class, 'approve'])->name('pendaftar.approve');
    Route::patch('/pendaftar/{id}/reject',     [PendaftarController::class, 'reject'])->name('pendaftar.reject');

    // Batch & Kuota
    Route::get('/batch',   [BatchController::class, 'index'])->name('batch.index');
    Route::post('/batch',  [BatchController::class, 'store'])->name('batch.store');
    Route::patch('/batch/{id}', [BatchController::class, 'update'])->name('batch.update');

    // Riwayat
    Route::get('/riwayat', [DashboardController::class, 'riwayat'])->name('riwayat');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});