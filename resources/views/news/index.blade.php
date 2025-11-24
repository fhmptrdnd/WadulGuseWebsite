<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Berita</title>
</head>
<body>
    <h1>Daftar Berita & Pengumuman</h1>
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
    <hr>

    @forelse ($news as $item)
        <div style="border: 1px solid #eee; padding: 10px; margin-bottom: 15px;">
            <h2><a href="{{ route('news.show', $item->slug) }}">{{ $item->judul_berita }}</a></h2>
            @if ($item->gambar_thumbnail)
                <img src="{{ asset('storage/' . $item->gambar_thumbnail) }}" alt="Thumbnail" width="100"><br>
            @endif
            <p>{{ Str::limit($item->konten, 150) }}</p>
            <small>Dibuat: {{ $item->tanggal_dibuat->format('d M Y') }} oleh Admin: {{ $item->admin->name }}</small>
        </div>
    @empty
        <p>Belum ada berita yang dipublikasikan.</p>
    @endforelse
</body>
</html>