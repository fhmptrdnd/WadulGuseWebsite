<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita: {{ $newsItem->judul_berita }}</title>
</head>
<body>
    <h1>Edit Berita</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.news.update', $newsItem->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="judul_berita">Judul Berita:</label><br>
        <input type="text" name="judul_berita" value="{{ old('judul_berita', $newsItem->judul_berita) }}" required style="width: 100%;"><br>

        <label for="konten">Konten Berita:</label><br>
        <textarea name="konten" rows="10" required style="width: 100%;">{{ old('konten', $newsItem->konten) }}</textarea><br>

        <label for="gambar_thumbnail">Ganti Gambar Thumbnail (Opsional, Maks 2MB):</label><br>
        @if ($newsItem->gambar_thumbnail)
            <p>Foto Saat Ini: <a href="{{ asset('storage/' . $newsItem->gambar_thumbnail) }}" target="_blank">Lihat</a></p>
        @endif
        <input type="file" name="gambar_thumbnail"><br><br>

        <button type="submit" style="background-color: blue; color: white;">Update Berita</button>
        <a href="{{ route('admin.news.index') }}">Batal</a>
    </form>
</body>
</html>