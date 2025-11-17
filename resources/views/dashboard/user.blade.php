<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Saya</title>
</head>
<body>
    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <a href="{{ route('reports.create') }}" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">
        + Buat Laporan Baru
    </a>

    <hr>

    <h2>Notifikasi</h2>
    @forelse (Auth::user()->unreadNotifications as $notification)
        <div style="background-color: #e6f7ff; border-left: 5px solid #0056b3; padding: 10px; margin-bottom: 10px;">
            {{ $notification->data['message'] }}
            <small style="float: right;">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>Tidak ada notifikasi baru.</p>
    @endforelse

    <hr>
    <h2>Daftar Laporan Saya</h2>

    @forelse ($reports as $report)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
            <h3>{{ $report->title }} (Status: {{ strtoupper($report->status) }})</h3>
            <p>Kategori: {{ $report->category }} | Lokasi: {{ $report->location }}</p>

            @if ($report->feedback)
                <p style="color: blue; font-weight: bold;">Feedback Admin: {{ $report->feedback }}</p>
            @endif

            <div style="margin-top: 10px;">
                @if ($report->status === 'pending')
                    <a href="{{ route('reports.edit', $report->id) }}" style="background-color: orange; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;">
                        Edit Laporan
                    </a>

                    <form method="POST" action="{{ route('reports.destroy', $report->id) }}" style="display:inline; margin-left: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus laporan ini?')" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                            Hapus Laporan
                        </button>
                    </form>
                @else
                    <p style="color: gray; display: inline;">*Tidak dapat diedit atau dihapus karena sudah diproses.</p>
                @endif
            </div>
        </div>
    @empty
        <p>Anda belum membuat laporan.</p>
    @endforelse
</body>
</html>
