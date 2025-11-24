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
            $status = $request->status;

            // 1. Tentukan Rules Validasi Bersyarat (dari implementasi pertama Anda)
            $rules = [
                'status' => ['required', 'in:pending,verified,on_progress,done,rejected'],
                'feedback' => ['nullable', 'string'],
                'admin_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                'opd_id' => ['nullable', 'exists:kategori_opd,opd_id'],
                'prioritas' => ['nullable', 'in:rendah,sedang,tinggi'],
            ];

            // Terapkan logika wajib isi (required)
            if ($status === 'verified') {
                $rules['opd_id'][] = 'required';
                $rules['prioritas'][] = 'required';
            } elseif ($status === 'on_progress' || $status === 'done' || $status === 'rejected') {
                $rules['feedback'][] = 'required';
            }

            $validatedData = $request->validate($rules);

            // 2. Upload Foto Admin
            $filepath = $report->admin_photo;
            if ($request->hasFile('admin_photo')) {
                if ($report->admin_photo && Storage::disk('public')->exists($report->admin_photo)) {
                    Storage::disk('public')->delete($report->admin_photo);
                }
                $filepath = $request->file('admin_photo')->store('reports/admin_proofs', 'public');
            }

            // 3. Simpan Perubahan Status & Detail Admin
            $report->status = $validatedData['status'];
            $report->admin_photo = $filepath;
            $report->feedback = $validatedData['feedback'] ?? (($status === 'verified' && !isset($validatedData['feedback'])) ? null : $report->feedback);

            if ($status === 'verified') {
                $report->opd_id = $validatedData['opd_id'];
                $report->prioritas = $validatedData['prioritas'];
                $report->ditangani_oleh = Auth::id(); // Admin yang menangani
            } else {
                // Jika status berubah dari verified ke status lain, kita kosongkan opd/prioritas (opsional)
                // $report->opd_id = null;
            }

            $report->save();
            $report->user->notify(new ReportStatusUpdated($report));

            return redirect()->route('dashboard')->with('success', 'Laporan berhasil diperbarui dan notifikasi dikirim.');
        }

        elseif (Auth::id() === $report->user_id && $report->status === 'pending') {

            // 1. Validasi Input User (menggunakan validasi yang lebih sederhana dari implementasi kedua)
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string',
                'location' => 'required|string',
                'description' => 'required|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            ]);

            // 2. Handle Photo Upload/Update User
            $filepath = $report->photo;
            if ($request->hasFile('photo')) {
                if ($report->photo && Storage::disk('public')->exists($report->photo)) {
                    Storage::disk('public')->delete($report->photo);
                }
                $filepath = $request->file('photo')->store('reports/photos', 'public');
            }

            // 3. Update Data Laporan User
            // Kita hanya mengizinkan kolom yang divalidasi (title, category, etc.) yang diupdate.
            $report->update(array_merge($validatedData, ['photo' => $filepath]));

            return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil diubah.');

        }

        else {
            // Jika tidak lolos Admin, dan tidak lolos User (misalnya status sudah 'verified')
            abort(403, 'Akses ditolak. Anda tidak diizinkan mengubah laporan ini.');
        }
    }

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
