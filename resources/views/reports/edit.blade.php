<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Laporan: {{ $report->title }}</title>
</head>
<body>
    <h1>Edit Laporan Anda</h1>

    <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') <label for="title">Judul:</label>
        <input type="text" name="title" value="{{ old('title', $report->title) }}" required><br>

        <label for="description">Deskripsi:</label>
        <textarea name="description" required>{{ old('description', $report->description) }}</textarea><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>
