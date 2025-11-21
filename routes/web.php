<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\DashboardController;


Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    // User Profile Update
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');

    // News Listing
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');

    // Report Submission
    Route::get('/reports/create', [ReportController::class, 'index'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin: edit n feedback
    Route::put('/reports/{report}', [DashboardController::class, 'update'])->name('reports.update');

    // User: hapus laporan
    Route::delete('/reports/{report}', [DashboardController::class, 'destroy'])->name('reports.destroy');

    Route::get('/reports/{report}/edit', [DashboardController::class, 'edit'])->name('reports.edit');
});

Route::get('/', function () {
    return view('welcome');
});
