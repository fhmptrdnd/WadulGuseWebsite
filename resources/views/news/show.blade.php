<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $newsItem->judul_berita }}</title>
</head>
<body>
    <a href="{{ route('news.index') }}">← Kembali ke Berita</a>
    <hr>

    <h1>{{ $newsItem->judul_berita }}</h1>

    <small>Dibuat: {{ $newsItem->tanggal_dibuat->format('d M Y H:i') }} oleh {{ $newsItem->admin->name }}</small>
    <hr>

    @if ($newsItem->gambar_thumbnail)
        <img src="{{ asset('storage/' . $newsItem->gambar_thumbnail) }}" alt="Thumbnail" style="max-width: 100%; height: auto;"><br>
    @endif

    <div>
        {!! nl2br(e($newsItem->konten)) !!}
    </div>
</body>
</html>