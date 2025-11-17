<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan Baru</title>
</head>
<body>
    <h1>Formulir Laporan Baru</h1>
    <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
    <hr>

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf

        <label for="title">Judul Laporan:</label><br>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required style="width: 100%; padding: 8px;"><br>
        @error('title') <span style="color: red;">{{ $message }}</span><br> @enderror
        <br>

        <label for="category">Kategori:</label><br>
        <select id="category" name="category" required style="width: 100%; padding: 8px;">
            <option value="">Pilih Kategori</option>
            <option value="Infrastruktur" {{ old('category') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
            <option value="Layanan Publik" {{ old('category') == 'Layanan Publik' ? 'selected' : '' }}>Layanan Publik</option>
            <option value="Keamanan" {{ old('category') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
            <option value="Lingkungan" {{ old('category') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select><br>
        @error('category') <span style="color: red;">{{ $message }}</span><br> @enderror
        <br>

        <label for="location">Lokasi Kejadian (Cth: Jl. Kartini No. 5, Jember):</label><br>
        <input type="text" id="location" name="location" value="{{ old('location') }}" required style="width: 100%; padding: 8px;"><br>
        @error('location') <span style="color: red;">{{ $message }}</span><br> @enderror
        <br>

        <label for="description">Deskripsi Detail Laporan:</label><br>
        <textarea id="description" name="description" rows="5" required style="width: 100%; padding: 8px;">{{ old('description') }}</textarea><br>
        @error('description') <span style="color: red;">{{ $message }}</span><br> @enderror
        <br>

        <label for="photo">Unggah Foto (Maks. 5MB, JPG/PNG):</label><br>
        <input type="file" id="photo" name="photo"><br>
        @error('photo') <span style="color: red;">{{ $message }}</span><br> @enderror
        <br>

        <button type="submit" style="background-color: #007bff; color: white; padding: 10px 15px; border: none; cursor: pointer;">
            KIRIM LAPORAN
        </button>
    </form>
</body>
</html>
