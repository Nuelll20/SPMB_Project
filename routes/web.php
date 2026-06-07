<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

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