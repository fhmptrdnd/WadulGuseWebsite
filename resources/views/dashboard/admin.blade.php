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

        .report-card select, .report-card input[type="number"], .report-card input[type="file"], .report-card textarea, .report-card button {
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

    <div class="nav-menu" style="display: flex; align-items: center;">
        <a href="{{ route('profile.show') }}" class="nav-item" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">
            Profile Admin
        </a>

        <a href="{{ route('admin.users.index') }}" class="nav-item" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">
            Kelola Profil
        </a>

        {{-- <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">Keluar</button>
        </form> --}}

        <a href="{{ route('admin.news.index') }}" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">
            Manajemen Berita
        </a>
    </div>

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

    @php
        $opds = App\Models\KategoriOpd::all();
    @endphp

    @forelse ($reports as $report)
        <div class="report-card">
            <h3>Laporan #{{ $report->id }} - {{ $report->title }}</h3>
            <p style="font-size: 0.9em; color: #666; margin-top: -10px; margin-bottom: 5px;">
                Dibuat: {{ $report->created_at->format('d M Y H:i') }} | Terakhir Diperbarui: {{ $report->updated_at->format('d M Y H:i') }}
            </p>
            <p>Dibuat Oleh: {{ $report->user->name }} | NIK: {{ $report->user->nik }}</p>
            <p>Status Saat Ini: <strong>{{ strtoupper($report->status) }}</strong> | Prioritas Awal: <strong>{{ strtoupper($report->prioritas) }}<strong></p>

            <p style="font-weight: bold;">Ditangani Oleh OPD:
                {{ $report->opd->nama_opd ?? 'BELUM DITUGASKAN' }}
                @if($report->handler)
                    (Diupdate Oleh Admin: {{ $report->handler->name }})
                @endif
            </p>

            <p>Deskripsi: {{ $report->description }}</p>

            @if ($report->photo)
                <p>Foto Awal User: <a href="{{ asset('storage/' . $report->photo) }}" target="_blank">Lihat Foto</a></p>
            @endif
            @if ($report->admin_photo)
                <p>Foto Bukti Admin: <a href="{{ asset('storage/' . $report->admin_photo) }}" target="_blank">Lihat Bukti Terakhir</a></p>
            @endif

            <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data" id="report-form-{{ $report->id }}">
                @csrf
                @method('PUT')

                <hr>

                <label for="status_{{ $report->id }}">Ubah Status:</label>
                <select id="status_{{ $report->id }}" name="status" required onchange="toggleAdminFields(this, {{ $report->id }})">
                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="on_progress" {{ $report->status === 'on_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="done" {{ $report->status === 'done' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <div id="opd-prioritas-group-{{ $report->id }}" style="display: none;">

                    <label for="opd_id_{{ $report->id }}">Tugaskan ke OPD (Wajib, Hanya Terverifikasi):</label>
                    <select id="opd_id_{{ $report->id }}" name="opd_id">
                        <option value="">-- Pilih OPD (Tidak Ditugaskan) --</option>
                        @foreach ($opds as $opd)
                            <option value="{{ $opd->opd_id }}" {{ old('opd_id', $report->opd_id) == $opd->opd_id ? 'selected' : '' }}>
                                {{ $opd->nama_opd }} (Tanggung: {{ $opd->kategori_tanggungan }})
                            </option>
                        @endforeach
                    </select>

                    <label for="prioritas_id_{{ $report->id }}">Prioritas Ditetapkan (Wajib, Hanya Terverifikasi):</label>
                    <select id="prioritas_id_{{ $report->id }}" name="prioritas">
                        <option value="rendah" {{ old('prioritas', $report->prioritas) === 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ old('prioritas', $report->prioritas) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ old('prioritas', $report->prioritas) === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <div id="feedback-group-{{ $report->id }}">

                    <label for="feedback_{{ $report->id }}">Feedback Admin:</label>
                    <textarea id="feedback_{{ $report->id }}" name="feedback" rows="3">{{ old('feedback', $report->feedback) }}</textarea>
                </div>

                <div id="photo-upload-group-{{ $report->id }}" style="display: none;">
                    <label for="admin_photo_{{ $report->id }}">Upload Foto Bukti/Progres (Opsional):</label>
                    <input type="file" id="admin_photo_{{ $report->id }}" name="admin_photo">
                </div>

                <button type="submit" style="background-color: blue; color: white;">
                    Update & Kirim Notifikasi
                </button>
            </form>

        </div>
    @empty
        <p>Tidak ada laporan baru.</p>
    @endforelse

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @forelse ($reports as $report)
            const selectElement = document.getElementById('status_{{ $report->id }}');
            if (selectElement) {
                toggleAdminFields(selectElement, {{ $report->id }});
            }
        @empty
        @endforelse
    });

    function toggleAdminFields(selectElement, reportId) {
        const status = selectElement.value;
        const opdPrioritasGroup = document.getElementById('opd-prioritas-group-' + reportId);
        const photoUploadGroup = document.getElementById('photo-upload-group-' + reportId);

        const opdField = document.getElementById('opd_id_' + reportId);
        const prioritasField = document.getElementById('prioritas_id_' + reportId);
        const feedbackField = document.getElementById('feedback_' + reportId);

        if (status === 'verified') {
            opdPrioritasGroup.style.display = 'block';
            opdField.setAttribute('required', 'required');
            prioritasField.setAttribute('required', 'required');
        } else {
            opdPrioritasGroup.style.display = 'none';
            opdField.removeAttribute('required');
            prioritasField.removeAttribute('required');
        }

        if (status === 'verified' || status === 'on_progress' || status === 'done') {
            photoUploadGroup.style.display = 'block';
        } else {
            photoUploadGroup.style.display = 'none';
        }

        if (status === 'on_progress' || status === 'done' || status === 'rejected') {
            feedbackField.setAttribute('required', 'required');
        } else {
            feedbackField.removeAttribute('required');
        }
    }
</script>
</body>
</html>
