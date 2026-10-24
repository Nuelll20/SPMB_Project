<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)
    ->name('landing');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/kepsek.php';
require __DIR__.'/orang_tua.php';