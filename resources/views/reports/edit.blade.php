<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Laporan: {{ $report->title }}</title>
</head>
<body>
    <h1>Edit Laporan Anda</h1>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Judul Laporan:</label><br>
        <input type="text" name="title" value="{{ old('title', $report->title) }}" required style="width: 100%;"><br>
        <br>

        <label for="category">Kategori:</label><br>
        <select name="category" required style="width: 100%;">
            <option value="Infrastruktur" {{ old('category', $report->category) == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
            <option value="Layanan Publik" {{ old('category', $report->category) == 'Layanan Publik' ? 'selected' : '' }}>Layanan Publik</option>
            <option value="Keamanan" {{ old('category', $report->category) == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
            <option value="Lingkungan" {{ old('category', $report->category) == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
            <option value="Lainnya" {{ old('category', $report->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select><br>
        <br>

        <label for="location">Lokasi Kejadian:</label><br>
        <input type="text" name="location" value="{{ old('location', $report->location) }}" required style="width: 100%;"><br>
        <br>

        <label for="description">Deskripsi Detail Laporan:</label><br>
        <textarea name="description" rows="5" required style="width: 100%;">{{ old('description', $report->description) }}</textarea><br>
        <br>

        <label for="photo">Ganti Foto (Kosongkan jika tidak ingin diubah):</label><br>
        @if ($report->photo)
            <p>Foto Saat Ini: <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">Lihat</a></p>
        @endif
        <input type="file" name="photo"><br>
        <br>

        <button type="submit" style="background-color: blue; color: white; padding: 10px 15px; border: none; cursor: pointer;">
            Simpan Perubahan
        </button>
    </form>

    <br>
    <a href="{{ route('dashboard') }}" style="color: gray;">Kembali ke Dashboard</a>
</body>
</html>
