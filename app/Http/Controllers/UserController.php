<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $user->update($request->all());

        return response()->json(['message' => 'Profile Berhasil Diperbarui!', 'user' => $user]);
    }
}
