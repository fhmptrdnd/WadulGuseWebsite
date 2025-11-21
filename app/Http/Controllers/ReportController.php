<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Notifications\NewReportSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReportStatusUpdated;

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

        // 3. Simpan Laporan ke Database
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

    public function update(Request $request, Report $report)
    {
        // 1. Validasi Input Admin
        $validatedData = $request->validate([
            'status' => 'required|in:pending,verified,on_progress,done,rejected',
            'feedback' => 'nullable|string',
        ]);

        // 2. Perbarui Laporan
        $report->update([
            'status' => $validatedData['status'],
            'feedback' => $validatedData['feedback'],
        ]);

        // 3. Kirim Notifikasi ke User
        if ($report->user) {
            $report->user->notify(new ReportStatusUpdated($report));
        }

        // 4. Redirect Admin kembali ke dashboard
        return redirect()->route('dashboard')->with('success', 'Status laporan #' . $report->id . ' berhasil diperbarui dan notifikasi telah dikirim ke pengguna.');
    }
}
