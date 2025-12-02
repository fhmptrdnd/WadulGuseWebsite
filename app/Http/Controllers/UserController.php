<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query: Hanya user biasa
        $query = User::where('role', 'user')->latest();

        // 2. Logika Searching Terpusat
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $filter = $request->filter; // Ambil nilai dropdown (name, nik, atau email)

            $query->where(function($q) use ($search, $filter) {
                // Jika user memilih filter spesifik
                if ($filter === 'nik') {
                    $q->where('nik', 'like', "%{$search}%");
                }
                elseif ($filter === 'email') {
                    $q->where('email', 'like', "%{$search}%");
                }
                elseif ($filter === 'name') {
                    $q->where('name', 'like', "%{$search}%");
                }
                // Jika tidak ada filter (default), cari di semua kolom
                else {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                }
            });
        }

        // 3. Paginate dengan query string agar search tidak hilang saat pindah page
        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
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
