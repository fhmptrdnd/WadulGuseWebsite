<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Berita Admin</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .news-item { 
            border: 1px solid #ccc; 
            padding: 15px; 
            margin-bottom: 15px; 
            overflow: auto; /* Clearfix */
        }
        .news-item h2 { margin-top: 0; }
        .news-item img { float: left; margin-right: 15px; max-width: 150px; }
        .action-group { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Manajemen Berita</h1>
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
    | 
    <a href="{{ route('admin.news.create') }}" style="color: green;">+ Tambah Berita Baru</a>
    <hr>
    
    @if (session('success'))
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    @forelse ($news as $item)
        <div class="news-item">
            {{-- [DIPERBAIKI] Tampilkan thumbnail, jika ada --}}
            @if ($item->gambar_thumbnail)
                <img src="{{ asset('storage/' . $item->gambar_thumbnail) }}" alt="{{ $item->judul_berita }}">
            @endif
            
            {{-- [DIPERBAIKI] Judul dan link ke detail (publik) --}}
            <h2><a href="{{ route('news.show', $item->slug) }}" target="_blank">{{ $item->judul_berita }}</a></h2>
            
            {{-- [MODIFIED] Menampilkan Admin dan Tanggal Saja (tanpa status/views/kategori) --}}
            <p style="font-size: 0.85em; color: #555;">
                Dibuat: {{ $item->tanggal_dibuat->format('d M Y H:i') }} | Admin: {{ $item->admin->name }}
            </p>

            <p>{{ Str::limit(strip_tags($item->konten), 150) }}</p>
            
            {{-- [TAMBAHAN] Group Aksi Manajemen --}}
            <div class="action-group">
                {{-- Tombol Edit --}}
                <a href="{{ route('admin.news.edit', $item->id) }}" style="color: orange; margin-right: 10px; text-decoration: none; border: 1px solid orange; padding: 5px;">
                    Edit
                </a>
                
                {{-- Tombol Hapus --}}
                <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus berita ini?')" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                        Hapus
                    </button>
                </form>
            </div>
            
            <div style="clear: both;"></div>
        </div>
    @empty
        <p>Tidak ada berita yang ditemukan. <a href="{{ route('admin.news.create') }}">Tambah Sekarang</a></p>
    @endforelse
</body>
</html>