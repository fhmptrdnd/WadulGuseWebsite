<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // View User
    // Menampilkan daftar semua berita (semua dianggap published)
    public function index(Request $request)
    {
        // 1. Query Dasar
        $query = News::with('admin')->orderByDesc('tanggal_dibuat');

        // 2. Logic Searching (Server Side)
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_berita', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        // 3. Paginate + Query String
        $news = $query->paginate(6)->withQueryString();

        return view('news.index', compact('news'));
    }

    // Menampilkan detail satu berita
    public function show($slug)
    {
        $newsItem = News::where('slug', $slug)
                        ->firstOrFail();

        // Tidak ada increment jumlah_views
        return view('news.show', compact('newsItem'));
    }

    // Admin View

    public function adminIndex(Request $request )    {
        $query = News::with('admin')->orderByDesc('tanggal_dibuat');

        // 2. Logic Searching (Server Side)
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_berita', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        // 3. Paginate + Query String
        $news = $query->paginate(10)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    // Menyimpan berita baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_berita' => 'required|string|max:200',
            'konten' => 'required|string',
            'gambar_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filepath = null;
        if ($request->hasFile('gambar_thumbnail')) {
            $filepath = $request->file('gambar_thumbnail')->store('news/thumbnails', 'public');
        }

        News::create([
            'admin_id' => Auth::id(),
            'judul_berita' => $validatedData['judul_berita'],
            'slug' => Str::slug($validatedData['judul_berita']) . '-' . time(),
            'konten' => $validatedData['konten'],
            'gambar_thumbnail' => $filepath,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil disimpan!');
    }

    public function edit(News $newsItem)
    {
        return view('admin.news.edit', compact('newsItem'));
    }

    // Memperbarui berita
    public function update(Request $request, News $newsItem)
    {
        $validatedData = $request->validate([
            'judul_berita' => 'required|string|max:200',
            'konten' => 'required|string',
            'gambar_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filepath = $newsItem->gambar_thumbnail;
        $slug = $newsItem->slug;

        if ($validatedData['judul_berita'] !== $newsItem->judul_berita) {
            $slug = Str::slug($validatedData['judul_berita']) . '-' . time();
        }

        if ($request->hasFile('gambar_thumbnail')) {
            if ($newsItem->gambar_thumbnail && Storage::disk('public')->exists($newsItem->gambar_thumbnail)) {
                Storage::disk('public')->delete($newsItem->gambar_thumbnail);
            }
            $filepath = $request->file('gambar_thumbnail')->store('news/thumbnails', 'public');
        }

        $newsItem->update([
            'judul_berita' => $validatedData['judul_berita'],
            'slug' => $slug,
            'konten' => $validatedData['konten'],
            'gambar_thumbnail' => $filepath,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $newsItem)
    {
        if ($newsItem->gambar_thumbnail && Storage::disk('public')->exists($newsItem->gambar_thumbnail)) {
            Storage::disk('public')->delete($newsItem->gambar_thumbnail);
        }
        $newsItem->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
