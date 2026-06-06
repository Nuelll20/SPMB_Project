<?php
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/forgot-password', function () {
    return "Halaman Lupa Password sedang dalam pengembangan.";
})->name('password.request');

Route::get('/register', function () {
    return "Halaman Register sedang dalam pengembangan.";
})->name('register');