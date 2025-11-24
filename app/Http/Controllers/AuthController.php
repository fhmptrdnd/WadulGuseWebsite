<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- MENAMPILKAN HALAMAN ---

    public function showLanding() {
        return view('landpage');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    // --- PROSES LOGIKA ---

    public function processRegister(Request $request)
    {
        // 1. Validasi Input (Cek kelengkapan & keunikan)
        $request->validate([
            'name'     => 'required|string|max:255',
            'nik'      => 'required|numeric|unique:users',
            'email'    => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
            'alamat'   => 'required|string',
            'phone'    => 'required|numeric',
        ]);

        // 2. Simpan ke Database
        User::create([
            'name'     => $request->name,
            'nik'      => $request->nik,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Password di-enkripsi
            'alamat'   => $request->alamat,
            'phone'    => $request->phone,
        ]);

        // 3. Redirect ke Login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Cek kecocokan data
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Jika berhasil, masuk ke dashboard (atau sementara ke home)
            return redirect()->route('home');
        }

        // 3. Jika gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
