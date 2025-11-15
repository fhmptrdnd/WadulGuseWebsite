<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
        ]);

        $filepath = null;
        if ($request->hasFile('photo')) {
            $filepath = $request->file('photo')->store('photos', 'reports');
        }

        $report = Report::create([
            'user_id' => $validatedData['user_id'],
            'title' => $validatedData['title'],
            'category' => $validatedData['category'],
            'location' => $validatedData['location'],
            'description' => $validatedData['description'],
            'photo' => $filepath,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Laporan berhasil dibuat!', 'report' => $report]);
    }
}