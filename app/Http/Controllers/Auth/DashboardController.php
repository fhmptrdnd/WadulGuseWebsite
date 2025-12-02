<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request; // <--- INI WAJIB ADA
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ReportStatusUpdated;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard berdasarkan Peran (Admin atau User).
     */
    public function index(Request $request) // <--- Pastikan ada (Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search'); // Ambil kata kunci pencarian

        // ==========================================
        // 1. LOGIKA ADMIN (SEARCH GLOBAL)
        // ==========================================
        if ($user->role === 'admin') {
            // Mulai Query: Ambil semua laporan + data user-nya
            $query = Report::with('user');

            // Jika ada pencarian
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      // Admin bisa cari berdasarkan Nama atau NIK Pelapor
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('nik', 'like', "%{$search}%");
                      });
                });
            }

            // Paginate (10 per halaman) + Keep Search String
            $reports = $query->orderBy('created_at', 'desc')
                             ->paginate(2)
                             ->withQueryString();

            return view('dashboard.admin', compact('reports'));
        }

        // ------------------------------------------
        // LOGIKA USER (DENGAN SEARCH)
        // ------------------------------------------

        // 1. Ambil laporan milik user sendiri
        $query = $user->reports()->orderBy('created_at', 'desc');

        // 2. Cek apakah ada pencarian
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // 3. Paginate hasilnya (2 per halaman sesuai request)
        $reports = $query->paginate(2)->withQueryString();

        return view('dashboard.user', compact('reports'));
    }

    public function update(Request $request, Report $report)
    {
        $user = Auth::user();

        // =================================================
        // 1. LOGIKA ADMIN
        // =================================================
        if ($user->role === 'admin') {

            // [BARU] CEK STATUS FINAL
            // Jika status saat ini sudah 'done' atau 'rejected', tolak update.
            if (in_array($report->status, ['done', 'rejected'])) {
                return redirect()->back()->with('error', 'Laporan ini sudah Selesai atau Ditolak dan tidak dapat diubah lagi.');
            }

            // Validasi Input
            $rules = [
                'status'      => ['required', 'in:pending,verified,on_progress,done,rejected'],
                'feedback'    => ['nullable', 'string'],
                'admin_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                'opd_id'      => ['nullable', 'exists:kategori_opd,opd_id'],
                'prioritas'   => ['nullable', 'in:rendah,sedang,tinggi'],
            ];

            // Feedback wajib jika progress/selesai/tolak
            if (in_array($request->status, ['on_progress', 'done', 'rejected'])) {
                $rules['feedback'] = 'required';
            }

            // OPD & Prioritas wajib jika verifikasi
            if ($request->status === 'verified') {
                $rules['opd_id'] = 'required';
                $rules['prioritas'] = 'required';
            }

            $validated = $request->validate($rules);

            // Update Data
            $report->status = $validated['status'];

            if ($request->filled('feedback')) {
                $report->feedback = $validated['feedback'];
            }
            if ($request->filled('opd_id')) {
                $report->opd_id = $validated['opd_id'];
            }
            if ($request->filled('prioritas')) {
                $report->prioritas = $validated['prioritas'];
            }

            // Set Handler jika belum ada
            if (!$report->ditangani_oleh) {
                $report->ditangani_oleh = Auth::id();
            }

            // Upload Foto Admin
            if ($request->hasFile('admin_photo')) {
                if ($report->admin_photo && Storage::disk('public')->exists($report->admin_photo)) {
                    Storage::disk('public')->delete($report->admin_photo);
                }
                $report->admin_photo = $request->file('admin_photo')->store('reports/admin_proofs', 'public');
            }

            $report->save();

            // Notifikasi
            try {
                if (class_exists(ReportStatusUpdated::class) && $report->user) {
                    $report->user->notify(new ReportStatusUpdated($report));
                }
            } catch (\Exception $e) { }

            return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
        }

        // =================================================
        // 2. LOGIKA USER (HANYA JIKA PENDING)
        // =================================================
        elseif (Auth::id() === $report->user_id && $report->status === 'pending') {

            // ... (Kode update user tetap sama seperti sebelumnya) ...
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string',
                'location' => 'required|string',
                'description' => 'required|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            ]);

            if ($request->hasFile('photo')) {
                if ($report->photo) Storage::disk('public')->delete($report->photo);
                $report->photo = $request->file('photo')->store('reports/photos', 'public');
            } else {
                $report->photo = $report->photo; // keep old
            }

            $report->title = $validated['title'];
            $report->category = $validated['category'];
            $report->location = $validated['location'];
            $report->description = $validated['description'];
            $report->save();

            return redirect()->back()->with('success', 'Laporan berhasil diubah.');
        }

        else {
            abort(403, 'Akses ditolak.');
        }
    }

    /**
     * Hapus Laporan
     */
    public function destroy(Report $report)
    {
        if (Auth::id() !== $report->user_id) {
            abort(403);
        }

        if ($report->status !== 'pending') {
            return back()->with('error', 'Gagal hapus: Laporan sudah diproses.');
        }

        if ($report->photo && Storage::disk('public')->exists($report->photo)) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return redirect()->route('dashboard')->with('success', 'Laporan dihapus.');
    }
}
