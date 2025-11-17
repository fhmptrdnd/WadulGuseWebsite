<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'username'      => ['required', 'string', 'max:255', 'unique:users'],
            'nik'           => ['required',
                                'string',
                                'digits:16',
                                'unique:users',
                                // Rule REGEX untuk memastikan 4 digit pertama adalah 3509
                                'regex:/^3509\d{12}$/'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nomor_telepon' => ['required', 'string', 'unique:users'],
            'alamat'        => ['required', 'string'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username'      => $request->username,
            'nik'           => $request->nik,
            'name'          => $request->name,
            'email'         => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat'        => $request->alamat,
            'password'      => Hash::make($request->password),
        ]);

        Auth::login($user);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Akun Anda berhasil didaftarkan! Silakan masuk.');
    }
}
