<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita Baru</title>
</head>
<body>
    <h1>Tambah Berita Baru</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <label for="judul_berita">Judul Berita:</label><br>
        <input type="text" name="judul_berita" value="{{ old('judul_berita') }}" required style="width: 100%;"><br>

        <label for="konten">Konten Berita:</label><br>
        <textarea name="konten" rows="10" required style="width: 100%;">{{ old('konten') }}</textarea><br>

        <label for="gambar_thumbnail">Gambar Thumbnail (Opsional, Maks 2MB):</label><br>
        <input type="file" name="gambar_thumbnail"><br><br>

        <button type="submit" style="background-color: green; color: white;">Simpan Berita</button>
        <a href="{{ route('admin.news.index') }}">Batal</a>
    </form>
</body>
</html>