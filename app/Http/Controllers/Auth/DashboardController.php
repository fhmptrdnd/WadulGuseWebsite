<?php

namespace App\Http\Controllers\Auth;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReportStatusUpdated;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard berdasarkan Peran (Admin atau User).
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin: Tampilkan semua laporan terbaru
            $reports = Report::orderBy('created_at', 'desc')->get();
            return view('dashboard.admin', compact('reports'));
        }

        // User: Tampilkan laporan miliknya sendiri
        $reports = $user->reports()->orderBy('created_at', 'desc')->get();
        return view('dashboard.user', compact('reports'));
    }

    /**
     * Admin: Mengedit Status dan Feedback Laporan.
     *
     * @param
     */
    public function update(Request $request, Report $report)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $request->validate([
                'status' => ['required', 'in:pending,verified,on_progress,done,rejected'],
                'feedback' => ['nullable', 'string'],
            ]);

            $report->update($request->only('status', 'feedback'));

            // Kirim Notifikasi
            $report->user->notify(new ReportStatusUpdated($report));

            return redirect()->route('dashboard')->with('success', 'Laporan berhasil diperbarui dan notifikasi dikirim.');
        }

        elseif (Auth::id() === $report->user_id && $report->status === 'pending') {

            // 1. Validasi Input User
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string',
                'location' => 'required|string',
                'description' => 'required|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            ]);

            // 2. Handle Photo Upload/Update
            $filepath = $report->photo;
            if ($request->hasFile('photo')) {
                // Hapus foto lama
                if ($report->photo && Storage::disk('public')->exists($report->photo)) {
                    Storage::disk('public')->delete($report->photo);
                }
                $filepath = $request->file('photo')->store('reports/photos', 'public');
            }

            // 3. Update Data Laporan
            $report->update(array_merge($validatedData, ['photo' => $filepath]));

            return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil diubah.');

        }

        else {
            // Jika bukan Admin, bukan pemilik, atau status sudah berubah
            abort(403, 'Akses ditolak. Anda tidak diizinkan mengubah laporan ini.');
        }
    }
    // public function update(Request $request, Report $report)
    // {
    //     // 1. Validasi Hak Akses (Hanya Admin)
    //     if (Auth::user()->role !== 'admin') {
    //         abort(403, 'Akses ditolak.');
    //     }

    //     // 2. Validasi Input Admin
    //     $request->validate([
    //         'status' => ['required', 'in:pending,verified,on_progress,done,rejected'],
    //         'feedback' => ['nullable', 'string'],
    //     ]);

    //     // 3. Simpan Perubahan
    //     $report->status = $request->status;
    //     $report->feedback = $request->feedback;
    //     $report->save();

    //     // 4. Kirim Notifikasi kepada Pemilik Laporan
    //     $report->user->notify(new ReportStatusUpdated($report));

    //     return redirect()->route('dashboard')->with('success', 'Laporan berhasil diperbarui dan notifikasi dikirim.');
    // }

    /**
     * User: Menghapus Laporan Sendiri (Hanya jika Status Pending).
     */
    public function destroy(Report $report)
    {
        // 1. Validasi Kepemilikan dan Hak Akses
        if (Auth::id() !== $report->user_id) {
            abort(403, 'Anda hanya dapat menghapus laporan milik sendiri.');
        }

        // 2. Validasi Status (Hanya boleh dihapus jika 'pending')
        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan tidak dapat dihapus karena sudah mulai diproses.');
        }

        // 3. Hapus Laporan
        $report->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus.');
    }

    public function edit(Report $report)
    {
        // Pastikan hanya user pemilik yang bisa edit
        if (Auth::id() !== $report->user_id || $report->status !== 'pending') {
            abort(403);
        }
        return view('reports.edit', compact('report'));
    }
}
