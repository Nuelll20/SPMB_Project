<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\KomponenTagihanController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.session')->group(function () {
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

    Route::get(
        '/admin/komponen-tagihan/{uid_tagihan}',
        [KomponenTagihanController::class, 'index']
    )->name('admin.komponen.index');

    Route::post(
        '/admin/komponen-tagihan',
        [KomponenTagihanController::class, 'store']
    )->name('admin.komponen.store');

    Route::put(
        '/admin/komponen-tagihan/{id}',
        [KomponenTagihanController::class, 'update']
    )->name('admin.komponen.update');

    Route::delete(
        '/admin/komponen-tagihan/{id}',
        [KomponenTagihanController::class, 'destroy']
    )->name('admin.komponen.destroy');

    Route::post(
        '/admin/berkas/validasi/{id}/{status}',
        [BerkasController::class, 'validasi']
    )->name('admin.berkas.validasi');

    Route::get('/admin/verifikasi-berkas/{uid}', [AdminController::class, 'showVerifikasi'])
        ->name('admin.verifikasi.show');

    Route::post('/admin/batch/save', [AdminController::class, 'saveBatch'])
        ->name('admin.batch.save');

    Route::delete('/admin/batch/{uid}', [AdminController::class, 'deleteBatch'])
        ->name('admin.batch.delete');
});