<?php

namespace App\Http\Controllers\Auth;

use App\Models\Report;
use App\Models\User;
use App\Models\KategoriOpd; // <-- Pastikan Import Model ini
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReportStatusUpdated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard berdasarkan Peran (Admin atau User).
     */
    public function index(Request $request)
{
    /** @var \App\Models\User */
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Start Query
        $query = Report::with(['user', 'opd']); // Eager load biar ringan

        // 1. Filter Search (Judul, Nama Pelapor, NIK)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function (Builder $qUser) use ($search) {
                      $qUser->where('name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Tanggal
        if ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }
        if ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        // 3. Filter Status
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        // Ambil Data (Pagination 10 per halaman)
        $reports = $query->latest()->paginate(10)->appends($request->query());

        // Ambil Data OPD untuk dropdown form
        $opds = \App\Models\KategoriOpd::all();

        return view('dashboard.admin', compact('reports', 'opds'));
    }

    // User tetap sama
    $reports = $user->reports()->latest()->get();
    return view('dashboard.user', compact('reports'));
}

    /**
     * Admin: Mengedit Status dan Feedback Laporan.
     */
    public function update(Request $request, Report $report)
    {
        // 1. Validasi Hak Akses (Admin Only)
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $status = $request->status;

        // Validasi input
        $rules = [
            'status' => ['required', 'in:pending,verified,on_progress,done,rejected'],
            'feedback' => ['nullable', 'string'],
            'admin_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'opd_id' => ['nullable', 'exists:kategori_opd,opd_id'],
            'prioritas' => ['nullable', 'in:rendah,sedang,tinggi'],
        ];

        // Conditional validation
        if ($status === 'verified') {
            $rules['opd_id'][] = 'required';
            $rules['prioritas'][] = 'required';
        } elseif ($status === 'on_progress' || $status === 'done' || $status === 'rejected') {
            $rules['feedback'][] = 'required';
        }

        $validatedData = $request->validate($rules);

        // 2. Upload Foto Admin (Opsional)
        $filepath = $report->admin_photo;
        if ($request->hasFile('admin_photo')) {
            if ($report->admin_photo) {
                Storage::disk('public')->delete($report->admin_photo);
            }
            $filepath = $request->file('admin_photo')->store('reports/admin_proofs', 'public');
        }

        // 3. Simpan Perubahan
        $report->status = $validatedData['status'];
        $report->admin_photo = $filepath;

        // Feedback Admin
        if (isset($validatedData['feedback'])) {
            $report->feedback = $validatedData['feedback'];
        } elseif ($status === 'verified' && !isset($validatedData['feedback'])) {
            $report->feedback = null;
        }

        // OPD & Prioritas (Hanya jika Verified)
        if ($status === 'verified') {
            $report->opd_id = $validatedData['opd_id'];
            $report->prioritas = $validatedData['prioritas'];
            $report->ditangani_oleh = Auth::id();
        }

        $report->save();

        // 4. Kirim Notifikasi
        $report->user->notify(new ReportStatusUpdated($report));

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil diperbarui dan notifikasi dikirim.');
    }

    /**
     * User: Menghapus Laporan Sendiri (Hanya jika Status Pending).
     */
    public function destroy(Report $report)
    {
        if (Auth::id() !== $report->user_id) {
            abort(403, 'Anda hanya dapat menghapus laporan milik sendiri.');
        }

        if ($report->status !== 'pending') {
            return back()->with('error', 'Laporan tidak dapat dihapus karena sudah mulai diproses.');
        }

        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Menampilkan form edit (Untuk User).
     */
    public function edit(Report $report)
    {
        if (Auth::id() !== $report->user_id || $report->status !== 'pending') {
            abort(403);
        }
        return view('reports.edit', compact('report'));
    }
}
