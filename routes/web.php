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
use App\Http\Controllers\KomponenTagihanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Landing Page Publik
|--------------------------------------------------------------------------
| Halaman utama tidak boleh mengarahkan otomatis ke dashboard admin/user.
| User luar hanya melihat landing page, lalu masuk lewat tombol login/register.
*/
Route::get('/', function () {
    $landingInfo = [
        'batch' => null,
        'batch_list' => collect(),
        'total_pendaftar' => 0,
        'approved' => 0,
        'rejected' => 0,
        'proses' => 0,
        'sisa_kuota' => 0,
        'is_open' => false,
    ];

    try {
        if (Schema::hasTable('pendaftaran')) {
            $landingInfo['total_pendaftar'] = DB::table('pendaftaran')->count();
            $landingInfo['approved'] = DB::table('pendaftaran')->where('status_pendaftaran', 'approved')->count();
            $landingInfo['rejected'] = DB::table('pendaftaran')->where('status_pendaftaran', 'rejected')->count();
            $landingInfo['proses'] = DB::table('pendaftaran')
                ->where(function ($query) {
                    $query->whereNull('status_pendaftaran')
                        ->orWhereIn('status_pendaftaran', ['pending', 'proses', 'draft']);
                })
                ->count();
        }

        if (Schema::hasTable('batch_pendaftaran')) {
            $batch = DB::table('batch_pendaftaran')
                ->where('is_active', 1)
                ->orderByDesc('tanggal_buka')
                ->orderByDesc('uid')
                ->first();

            if (! $batch) {
                $batch = DB::table('batch_pendaftaran')
                    ->orderByDesc('tanggal_buka')
                    ->orderByDesc('uid')
                    ->first();
            }

            $landingInfo['batch'] = $batch;

            if ($batch) {
                $jumlahBatch = Schema::hasTable('pendaftaran')
                    ? DB::table('pendaftaran')->where('id_batch_pendaftaran', $batch->uid)->count()
                    : 0;

                $landingInfo['sisa_kuota'] = max(0, (int) ($batch->kuota ?? 0) - $jumlahBatch);
                $landingInfo['is_open'] = (int) ($batch->is_active ?? 0) === 1 && $landingInfo['sisa_kuota'] > 0;
            }

            $landingInfo['batch_list'] = DB::table('batch_pendaftaran')
                ->orderByDesc('tanggal_buka')
                ->orderByDesc('uid')
                ->limit(3)
                ->get();
        }
    } catch (\Throwable $e) {
        // Landing page tetap bisa dibuka walaupun database belum siap.
    }

    return view('landing', compact('landingInfo'));
})->name('landing');


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
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


// ===================== ADMIN ROUTES =====================
// Semua route admin wajib melewati session role admin.
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

    // Komponen Tagihan
    Route::get('/admin/komponen-tagihan/{uid_tagihan}', [KomponenTagihanController::class, 'index'])->name('admin.komponen.index');
    Route::post('/admin/komponen-tagihan', [KomponenTagihanController::class, 'store'])->name('admin.komponen.store');
    Route::put('/admin/komponen-tagihan/{id}', [KomponenTagihanController::class, 'update'])->name('admin.komponen.update');
    Route::delete('/admin/komponen-tagihan/{id}', [KomponenTagihanController::class, 'destroy'])->name('admin.komponen.destroy');

    // Berkas Admin
    Route::post('/admin/berkas/validasi/{id}/{status}', [BerkasController::class, 'validasi'])->name('admin.berkas.validasi');

    Route::get('/admin/verifikasi-berkas/{uid}', [AdminController::class, 'showVerifikasi'])
        ->name('admin.verifikasi.show');

    Route::post('/admin/batch/save', [AdminController::class, 'saveBatch'])
        ->name('admin.batch.save');

    Route::delete('/admin/batch/{uid}', [AdminController::class, 'deleteBatch'])
        ->name('admin.batch.delete');
});


// ===================== ORANG TUA / USER ROUTES =====================
// Ini khusus akun orang tua dari tabel users.
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
