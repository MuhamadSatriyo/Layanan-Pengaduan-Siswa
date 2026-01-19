<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN, REGISTER, LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

/*
|--------------------------------------------------------------------------
| ROUTE SISWA (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->group(function () {

    // Dashboard siswa (form + status + riwayat)
    Route::get('/dashboard', [PengaduanController::class, 'dashboard'])
        ->name('dashboard');

    // Kirim pengaduan
    Route::post('/pengaduan/kirim', [PengaduanController::class, 'kirim'])
        ->name('pengaduan.kirim');

    // Cari status pengaduan berdasarkan nomor tiket
    Route::get('/pengaduan/cari', [PengaduanController::class, 'cari'])
        ->name('pengaduan.cari');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD PETUGAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [PengaduanController::class, 'dashboardPetugas'])
        ->name('petugas.dashboard');

    Route::post('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])
        ->name('pengaduan.updateStatus');

    Route::post('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'kirimTanggapan'])
        ->name('pengaduan.tanggapan');

});
