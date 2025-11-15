<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update($request->all());

        return response()->json(['message' => 'Profile Berhasil Diperbarui!', 'user' => $user]);
    }
}
