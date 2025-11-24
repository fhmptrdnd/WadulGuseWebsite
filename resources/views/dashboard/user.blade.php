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
            <p style="font-size: 0.9em; color: #666; margin-top: -10px; margin-bottom: 5px;">
                Dibuat: {{ $report->created_at->format('d M Y H:i') }} | Terakhir Diperbarui: {{ $report->updated_at->format('d M Y H:i') }}
            </p>
            {{--  Prioritas --}}
            <p>
                Kategori: {{ $report->category }} | Prioritas: {{ strtoupper($report->prioritas) }} | Lokasi: {{ $report->location }}
            </p>

            {{--  OPD yang Menangani --}}
            <p style="font-weight: bold; margin-top: 5px;">
                Ditangani Oleh OPD:
                {{ $report->opd->nama_opd ?? 'Belum Ditugaskan' }}
            </p>

            <hr>

            <p>Deskripsi Aduan:</p>
            <p>{{ $report->description }}</p>

            <p>Foto User:
                @if ($report->photo)
                    <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">Lihat Foto Awal</a>
                @else
                    Tidak ada foto.
                @endif
            </p>

            {{-- Foto Bukti Admin --}}
            @if ($report->admin_photo)
                <p>Foto Bukti Progres Admin: <a href="{{ asset('storage/' . $report->admin_photo) }}" target="_blank">Lihat Bukti</a></p>
            @endif

            {{-- Tampilan Feedback Admin --}}
            @if ($report->feedback)
                <p style="color: blue; font-weight: bold; margin-top: 10px;">Feedback Admin: </p>
                <div style="border-left: 3px solid blue; padding-left: 10px; margin-top: -10px;">
                    {{ $report->feedback }}
                </div>
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
