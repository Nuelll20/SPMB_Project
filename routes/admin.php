<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BatchPendaftaranController;
use App\Http\Controllers\BerkasController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin.session')->group(function () {
    Route::get('/dashboard-admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::post(
        '/admin/pendaftaran/{uid}/approve',
        [AdminController::class, 'approve']
    )
        ->whereNumber('uid')
        ->name('admin.pendaftaran.approve');

    Route::post(
        '/admin/pendaftaran/{uid}/reject',
        [AdminController::class, 'reject']
    )
        ->whereNumber('uid')
        ->name('admin.pendaftaran.reject');

    Route::get(
        '/admin/pendaftaran/{uid}/invoice',
        [AdminController::class, 'invoice']
    )
        ->whereNumber('uid')
        ->name('admin.pendaftaran.invoice');

    Route::post(
        '/admin/pendaftaran/{uid}/tagihan/save',
        [AdminController::class, 'saveTagihan']
    )
        ->whereNumber('uid')
        ->name('admin.pendaftaran.tagihan.save');

    Route::get(
        '/admin/berkas/{uid}/lihat/{filename?}',
        [BerkasController::class, 'showForAdmin']
    )
        ->whereNumber('uid')
        ->where('filename', '[^/]+')
        ->name('admin.berkas.show');

    Route::post(
        '/admin/berkas/validasi/{id}/{status}',
        [BerkasController::class, 'validasi']
    )
        ->whereNumber('id')
        ->whereIn('status', ['0', '1'])
        ->name('admin.berkas.validasi');

    Route::get(
        '/admin/verifikasi-berkas/{uid}',
        [AdminController::class, 'showVerifikasi']
    )
        ->whereNumber('uid')
        ->name('admin.verifikasi.show');

    Route::post(
        '/admin/batch/save',
        [BatchPendaftaranController::class, 'save']
    )->name('admin.batch.save');

    Route::delete(
        '/admin/batch/{uid}',
        [BatchPendaftaranController::class, 'destroy']
    )
        ->whereNumber('uid')
        ->name('admin.batch.delete');
});