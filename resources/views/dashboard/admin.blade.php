<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .notification-box {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 10px;
            margin-bottom: 10px;
            display: block;
        }
        .report-card {
            border: 2px solid #333;
            padding: 15px;
            margin-bottom: 20px;
            display: block;
        }
        .report-card select, .report-card textarea, .report-card button {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .report-card label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Halaman Administrator</h1>

    @if (session('success'))
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>

    <h2>Laporan Baru</h2>
    @forelse (Auth::user()->unreadNotifications as $notification)
        <div class="notification-box">
            Laporan ID #{{ $notification->data['report_id'] }} - {{ $notification->data['title'] }}
            <small style="float: right;">Dibuat: {{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>Tidak ada notifikasi laporan baru.</p>
    @endforelse

    <hr>
    <h2>Semua Laporan (Untuk Diproses)</h2>

    @forelse ($reports as $report)
        <div class="report-card">
            <h3>Laporan #{{ $report->id }} - {{ $report->title }}</h3>
            <p>Dibuat Oleh: {{ $report->user->name }} | NIK: {{ $report->user->nik }}</p>
            <p>Alamat: {{ $report->location }}</p>
            <p>Status Saat Ini: <strong>{{ strtoupper($report->status) }}</strong></p>

            <p>Deskripsi: {{ $report->description }}</p>
            @if ($report->photo)
                <p>Foto: <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">Lihat Foto</a></p>
            @endif

            <form method="POST" action="{{ route('reports.update', $report->id) }}">
                @csrf
                @method('PUT')

                <label for="status_{{ $report->id }}">Ubah Status:</label>
                <select id="status_{{ $report->id }}" name="status" required>
                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="on_progress" {{ $report->status === 'on_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="done" {{ $report->status === 'done' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <label for="feedback_{{ $report->id }}">Feedback Admin:</label>
                <textarea id="feedback_{{ $report->id }}" name="feedback" rows="3">{{ old('feedback', $report->feedback) }}</textarea>

                <button type="submit" style="background-color: blue; color: white;">
                    Update & Kirim Notifikasi
                </button>
            </form>
        </div>
    @empty
        <p>Tidak ada laporan baru.</p>
    @endforelse
</body>
</html>
