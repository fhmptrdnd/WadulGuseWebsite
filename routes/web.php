<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Depan
Route::get('/', [AuthController::class, 'showLanding'])->name('home');

// Halaman Login & Proses Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

// Halaman Register & Proses Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
