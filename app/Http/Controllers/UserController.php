<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Hanya tampilkan user biasa, bukan admin lain
        $users = User::where('role', 'user')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function deactivate(User $user)
    {
        // Otorisasi: Mencegah admin menonaktifkan diri sendiri atau admin lain (walaupun filter query sudah ada)
        if ($user->role === 'admin') {
             return back()->with('error', "Tidak dapat menonaktifkan Administrator.");
        }

        $user->update(['is_active' => false]);

        return back()->with('success', "Pengguna {$user->name} berhasil dinonaktifkan.");
    }

    public function activate(User $user)
    {
        if ($user->role === 'admin') {
             return back()->with('error', "Tidak dapat mengubah status Administrator.");
        }

        $user->update(['is_active' => true]);

        return back()->with('success', "Pengguna {$user->name} berhasil diaktifkan.");
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $user->update($request->all());

        return response()->json(['message' => 'Profile Berhasil Diperbarui!', 'user' => $user]);
    }
}
