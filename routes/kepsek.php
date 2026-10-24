<?php

use App\Http\Controllers\KepsekController;
use Illuminate\Support\Facades\Route;

Route::middleware('kepsek.session')->group(function () {
    Route::get('/dashboard-kepsek', [KepsekController::class, 'index'])
        ->name('kepsek.dashboard');

    Route::post('/kepsek/staf-spmb', [KepsekController::class, 'storeStaff'])
        ->name('kepsek.staf.store');

    Route::post('/kepsek/invoice/{uid}/approve', [KepsekController::class, 'approveInvoice'])
        ->name('kepsek.invoice.approve');

    Route::get('/kepsek/laporan-siswa/cetak', [KepsekController::class, 'printStudentReport'])
        ->name('kepsek.laporan.siswa');
});