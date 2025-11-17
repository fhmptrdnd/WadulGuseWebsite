<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Notifications\NewReportSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        $filepath = null;

        // 2. Upload Foto
        if ($request->hasFile('photo')) {
            $filepath = $request->file('photo')->store('reports/photos', 'public');
        }

        // 3. Simpan Laporan ke Database (Lebih aman)
        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'category' => $validatedData['category'],
            'location' => $validatedData['location'],
            'description' => $validatedData['description'],
            'photo' => $filepath,
            'status' => 'pending',
        ]);

        // 4. Kirim notif ke admin

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
             Notification::send($admins, new NewReportSubmitted($report));
        }


        return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil dikirim! Admin telah menerima notifikasi.');
    }
}
