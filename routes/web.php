<?php
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard_user.form_daftar');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/forgot-password', function () {
    return view('auth.forgot_pass');
})->name('password.request');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/forgot-password', function () {
    return "Fitur send email/proses reset password belum didefinisikan.";
})->name('password.email');

Route::get('/profil-ortu', function () {
    return view('dashboard_user.form_profilOrtu');
})->name('profil.ortu');