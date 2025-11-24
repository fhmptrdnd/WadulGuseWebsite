<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; // Pastikan controller ini ada
use App\Http\Controllers\Auth\RegisterController; // Pastikan controller ini ada
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Route Public ---
Route::get('/', function () {
    return view('landpage'); // Pastikan file resources/views/landpage.blade.php ada
})->name('home');

// --- Route Authentication (Login & Register) ---
// Jika menggunakan Laravel UI / Breeze default, sesuaikan controllernya
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- Route Admin Dashboard ---
// Saya tambahkan prefix 'admin' agar URL menjadi /admin/dashboard, /admin/laporan, dst.
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola Laporan
    Route::get('/laporan', [AdminController::class, 'reports'])->name('laporan');

    // Kelola Pengguna
    Route::get('/pengguna', [AdminController::class, 'users'])->name('pengguna');

    // Kelola Berita
    Route::get('/berita', [AdminController::class, 'news'])->name('berita');
});
