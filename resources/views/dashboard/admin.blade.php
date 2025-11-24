<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Wadul Guse</title>
    <style>
        /* --- CSS UTAMA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; min-height: 100vh; }
        .dashboard { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 260px; background: white; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; z-index: 10; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #eee; text-align: center; }
        .user-info { margin-top: 20px; display: flex; flex-direction: column; align-items: center; }
        .user-avatar { width: 60px; height: 60px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; }
        .nav-menu { margin-top: 20px; }
        .nav-item { padding: 15px 25px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px; color: #555; }
        .nav-item:hover, .nav-item.active { background: #e8f5e9; color: #28a745; border-right: 3px solid #28a745; }

        /* Main Content */
        .main-content { flex: 1; padding: 30px; margin-left: 260px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .content-section { display: none; animation: fadeIn 0.3s; }
        .content-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Search Filter Box */
        .filter-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        .filter-group { flex: 1; min-width: 150px; }
        .filter-group label { font-size: 12px; color: #666; margin-bottom: 5px; display: block; font-weight: 600; }
        .filter-group input, .filter-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }

        /* --- CARD ACCORDION STYLE --- */
        .report-card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 15px; overflow: hidden; border: 1px solid #e0e0e0; transition: 0.2s; }
        .report-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        /* Card Header (Selalu Tampil) */
        .card-header-row { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; background: #fff; }
        .card-header-row:hover { background: #f9f9f9; }

        .header-info { display: flex; align-items: center; gap: 15px; flex: 1; }
        .report-id { font-weight: bold; color: #28a745; background: #e8f5e9; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
        .report-main-info h4 { margin: 0; font-size: 16px; color: #333; }
        .report-main-info p { margin: 0; font-size: 13px; color: #777; margin-top: 3px; }

        .header-status { display: flex; align-items: center; gap: 15px; }

        /* Card Body (Disembunyikan Default) */
        .card-body { padding: 20px; border-top: 1px solid #eee; background: #fcfcfc; display: none; /* Hidden by default */ }
        .card-body.show { display: block; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* Detail Grid */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .detail-item label { font-size: 12px; color: #888; font-weight: bold; text-transform: uppercase; }
        .detail-item div { font-size: 14px; color: #333; margin-top: 3px; }
        .description-box { background: #fff; border: 1px solid #eee; padding: 15px; border-radius: 5px; margin-bottom: 20px; color: #555; line-height: 1.6; }

        /* Form Elements inside Card */
        .admin-action-area { background: #eef2f5; padding: 20px; border-radius: 8px; border: 1px solid #dae1e7; }
        .admin-action-area h5 { margin-bottom: 15px; color: #444; border-bottom: 1px solid #ccc; padding-bottom: 10px; }

        .btn-primary { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.2s; width: 100%; }
        .btn-primary:hover { background: #0056b3; }
        .btn-toggle { background: transparent; border: 1px solid #ccc; padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer; color: #555; display: flex; align-items: center; gap: 5px; }
        .btn-toggle:hover { background: #eee; }

        /* Status Badges */
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .bg-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .bg-verified { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .bg-on_progress { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
        .bg-done { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .bg-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .hidden { display: none; }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 style="color: #28a745;">Admin Panel</h2>
        </div>
        <div class="user-info">
            <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <h3 style="margin-top:10px;">{{ Auth::user()->name }}</h3>
            <p style="font-size: 12px; color: #777;">Administrator</p>
        </div>
        <div class="nav-menu">
            <div class="nav-item active" onclick="showPage('adminHome')">🏠 Beranda</div>
            <div class="nav-item" onclick="showPage('adminComplaints')">📢 Kelola Laporan</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width:100%; background:none; border:none; font-size:16px;">🚪 Keluar</button>
            </form>
        </div>
    </div>

    <div class="main-content">

        @if (session('success'))
            <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        <div id="adminHome" class="content-section active">
            <div class="top-bar">
                <h1>Dashboard Overview</h1>
            </div>

            <div class="stats-grid">
                <div class="stat-card" style="border-left-color: #ffc107;">
                    <h3>Menunggu</h3>
                    <div class="number">{{ $reports->where('status', 'pending')->count() }}</div>
                </div>
                <div class="stat-card" style="border-left-color: #17a2b8;">
                    <h3>Terverifikasi</h3>
                    <div class="number">{{ $reports->where('status', 'verified')->count() }}</div>
                </div>
                <div class="stat-card" style="border-left-color: #007bff;">
                    <h3>Diproses</h3>
                    <div class="number">{{ $reports->where('status', 'on_progress')->count() }}</div>
                </div>
                <div class="stat-card" style="border-left-color: #28a745;">
                    <h3>Selesai</h3>
                    <div class="number">{{ $reports->where('status', 'done')->count() }}</div>
                </div>
            </div>

            <h3>🔔 Aktivitas Terbaru</h3>
            <div>
                @forelse (Auth::user()->unreadNotifications as $notification)
                    <div class="notification-box">
                        <strong>Laporan Baru:</strong> {{ $notification->data['title'] }}
                        <small>({{ $notification->created_at->diffForHumans() }})</small>
                    </div>
                @empty
                    <p style="color:#777;">Tidak ada notifikasi baru.</p>
                @endforelse
            </div>
        </div>

        <div id="adminComplaints" class="content-section">
            <div class="top-bar">
                <h1>Kelola Laporan</h1>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" class="filter-box">
                <input type="hidden" name="tab" value="adminComplaints"> <div class="filter-group" style="flex: 2;">
                    <label>Cari (Judul / Pelapor / NIK)</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci...">
                </div>

                <div class="filter-group">
                    <label>Status</label>
                    <select name="status_filter">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status_filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status_filter') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="on_progress" {{ request('status_filter') == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                        <option value="done" {{ request('status_filter') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tanggal Awal</label>
                    <input type="date" name="date_start" value="{{ request('date_start') }}">
                </div>

                <div class="filter-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="date_end" value="{{ request('date_end') }}">
                </div>

                <div class="filter-group" style="flex: 0;">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-primary" style="padding: 10px 20px; width: auto;">🔍 Cari</button>
                </div>
                <div class="filter-group" style="flex: 0;">
                    <label>&nbsp;</label>
                    <a href="{{ route('dashboard') }}" style="display:block; padding: 10px 15px; background: #6c757d; color: white; border-radius: 5px; text-decoration: none;">Reset</a>
                </div>
            </form>

            @forelse ($reports as $report)
                <div class="report-card">
                    <div class="card-header-row" onclick="toggleDetail('detail-{{ $report->id }}')">
                        <div class="header-info">
                            <span class="report-id">#{{ $report->id }}</span>
                            <div class="report-main-info">
                                <h4>{{ Str::limit($report->title, 50) }}</h4>
                                <p>👤 {{ $report->user->name }} | 📅 {{ $report->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="header-status">
                            <span class="badge bg-{{ $report->status }}">{{ strtoupper($report->status) }}</span>
                            <button class="btn-toggle" type="button">
                                👁️ Lihat Detail & Proses
                            </button>
                        </div>
                    </div>

                    <div id="detail-{{ $report->id }}" class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Kategori</label>
                                <div>{{ $report->category }}</div>
                            </div>
                            <div class="detail-item">
                                <label>Lokasi</label>
                                <div>{{ $report->location }}</div>
                            </div>
                            <div class="detail-item">
                                <label>NIK Pelapor</label>
                                <div>{{ $report->user->nik }}</div>
                            </div>
                            <div class="detail-item">
                                <label>Prioritas</label>
                                <div>{{ $report->prioritas ? strtoupper($report->prioritas) : '-' }}</div>
                            </div>
                        </div>

                        <div class="detail-item" style="margin-bottom: 10px;">
                            <label>Isi Laporan</label>
                        </div>
                        <div class="description-box">
                            {{ $report->description }}
                        </div>

                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Foto Pelapor</label>
                                <div>
                                    @if ($report->photo)
                                        <a href="{{ asset('storage/' . $report->photo) }}" target="_blank" style="color: blue; text-decoration: underline;">📷 Buka Foto</a>
                                    @else
                                        <span style="color: #999;">Tidak ada foto</span>
                                    @endif
                                </div>
                            </div>
                            <div class="detail-item">
                                <label>Ditangani Oleh OPD</label>
                                <div>{{ $report->opd->nama_opd ?? 'Belum ditentukan' }}</div>
                            </div>
                        </div>

                        <div class="admin-action-area">
                            <h5>🛠️ Proses Laporan Ini</h5>
                            <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Ubah Status:</label>
                                    <select id="status_{{ $report->id }}" name="status" required onchange="toggleAdminFields(this, {{ $report->id }})">
                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                        <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Verified (Terverifikasi)</option>
                                        <option value="on_progress" {{ $report->status === 'on_progress' ? 'selected' : '' }}>On Progress (Diproses)</option>
                                        <option value="done" {{ $report->status === 'done' ? 'selected' : '' }}>Done (Selesai)</option>
                                        <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                                    </select>
                                </div>

                                <div id="opd-prioritas-group-{{ $report->id }}" class="hidden">
                                    <div class="form-group">
                                        <label>Tugaskan ke OPD:</label>
                                        <select id="opd_id_{{ $report->id }}" name="opd_id">
                                            <option value="">-- Pilih OPD --</option>
                                            @foreach ($opds as $opd)
                                                <option value="{{ $opd->opd_id }}" {{ old('opd_id', $report->opd_id) == $opd->opd_id ? 'selected' : '' }}>
                                                    {{ $opd->nama_opd }} ({{ $opd->kategori_tanggungan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Prioritas:</label>
                                        <select id="prioritas_id_{{ $report->id }}" name="prioritas">
                                            <option value="rendah" {{ old('prioritas', $report->prioritas) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                            <option value="sedang" {{ old('prioritas', $report->prioritas) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                            <option value="tinggi" {{ old('prioritas', $report->prioritas) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="photo-upload-group-{{ $report->id }}" class="hidden">
                                    <div class="form-group">
                                        <label>Upload Bukti Pengerjaan (Opsional):</label>
                                        <input type="file" name="admin_photo" accept="image/*">
                                        @if ($report->admin_photo)
                                            <small><a href="{{ asset('storage/' . $report->admin_photo) }}" target="_blank">Lihat Bukti Sebelumnya</a></small>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Feedback / Catatan:</label>
                                    <textarea id="feedback_{{ $report->id }}" name="feedback" rows="3" placeholder="Tulis pesan notifikasi ke user...">{{ old('feedback', $report->feedback) }}</textarea>
                                </div>

                                <button type="submit" class="btn-primary">Simpan Perubahan & Kirim Notifikasi</button>
                            </form>
                        </div>
                        </div>
                </div>
            @empty
                <div style="text-align:center; padding: 40px; color: #999;">
                    <p>Tidak ada laporan ditemukan sesuai filter.</p>
                </div>
            @endforelse

            <div style="margin-top: 20px;">
                {{ $reports->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>
</div>

<script>
    // 1. Navigasi Tab SPA
    function showPage(pageId) {
        document.querySelectorAll('.content-section').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));

        document.getElementById(pageId).classList.add('active');

        // Highlight Sidebar
        const navItems = document.querySelectorAll('.nav-item');
        if(pageId === 'adminHome') navItems[0].classList.add('active');
        if(pageId === 'adminComplaints') navItems[1].classList.add('active');
    }

    // 2. Accordion Show/Hide Detail
    function toggleDetail(elementId) {
        const el = document.getElementById(elementId);
        el.classList.toggle('show');
    }

    // 3. Logic Tampilan Form Dinamis
    document.addEventListener('DOMContentLoaded', function() {
        // Check URL params to stay on tab
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search') || urlParams.has('status_filter') || urlParams.has('date_start')) {
            showPage('adminComplaints');
        }

        // Init form fields state
        @foreach ($reports as $report)
            const selectElement = document.getElementById('status_{{ $report->id }}');
            if (selectElement) {
                toggleAdminFields(selectElement, {{ $report->id }});
            }
        @endforeach
    });

    function toggleAdminFields(selectElement, reportId) {
        const status = selectElement.value;

        const opdGroup = document.getElementById('opd-prioritas-group-' + reportId);
        const photoGroup = document.getElementById('photo-upload-group-' + reportId);

        const opdField = document.getElementById('opd_id_' + reportId);
        const prioritasField = document.getElementById('prioritas_id_' + reportId);
        const feedbackField = document.getElementById('feedback_' + reportId);

        // Logic OPD & Prioritas
        if (status === 'verified') {
            opdGroup.style.display = 'block';
            opdField.setAttribute('required', 'required');
            prioritasField.setAttribute('required', 'required');
        } else {
            opdGroup.style.display = 'none';
            opdField.removeAttribute('required');
            prioritasField.removeAttribute('required');
        }

        // Logic Upload Foto
        if (status === 'verified' || status === 'on_progress' || status === 'done') {
            photoGroup.style.display = 'block';
        } else {
            photoGroup.style.display = 'none';
        }

        // Logic Feedback Wajib
        if (status === 'on_progress' || status === 'done' || status === 'rejected') {
            feedbackField.setAttribute('required', 'required');
        } else {
            feedbackField.removeAttribute('required');
        }
    }
</script>

</body>
</html>
