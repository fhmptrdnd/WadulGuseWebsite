<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User - Wadul Guse</title>
    <style>
        /* COPY CSS DARI KODE AWAL KAMU KE SINI */
        /* Saya singkat demi kerapian, tapi pastikan style Dashboard, Sidebar, Card, Modal, dll ada di sini */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; min-height: 100vh; }
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: white; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .hidden { display: none !important; }
        /* ... Copy sisa CSS dashboard, card, table, modal, nav-item, dll ... */

        /* Styling tambahan untuk tombol */
        .btn-primary { background: #667eea; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; border: none; cursor: pointer;}
        .status-badge { padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .status-pending { background: #ffeeba; color: #856404; }
        .status-process { background: #b8daff; color: #004085; }
        .status-done { background: #c3e6cb; color: #155724; }
        .status-rejected { background: #f5c6cb; color: #721c24; }
    </style>
</head>
<body>
    <div id="dashboardUser" class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header" style="padding: 20px; text-align: center;">
                <h2 style="color: #667eea;">Wadul Guse</h2>
                <div class="user-info" style="margin-top: 20px;">
                    <div class="user-avatar" style="width:50px; height:50px; background:#667eea; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto; font-size:20px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="user-details" style="margin-top:10px;">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p style="font-size:12px; color:#666;">Masyarakat</p>
                    </div>
                </div>
            </div>
            <div class="nav-menu" style="margin-top: 20px;">
                <div class="nav-item active" onclick="showUserPage('home')" style="padding:15px 20px; cursor:pointer;">🏠 Beranda</div>
                <div class="nav-item" onclick="showUserPage('complaints')" style="padding:15px 20px; cursor:pointer;">📝 Laporan Saya</div>
                <div class="nav-item" onclick="showUserPage('profile')" style="padding:15px 20px; cursor:pointer;">👤 Profil</div>

                <form method="POST" action="{{ route('logout') }}" style="padding:15px 20px;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer; font-size:16px;">🚪 Keluar</button>
                </form>
            </div>
        </div>

        <div class="main-content">

            @if(session('success'))
                <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px;">
                    {{ session('success') }}
                </div>
            @endif

            <div id="userHome" class="content-section">
                <div class="top-bar">
                    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
                </div>

                <div class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div class="stat-card" style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                        <h3>Total Laporan</h3>
                        <div class="number" style="font-size:24px; font-weight:bold;">{{ $reports->count() }}</div>
                    </div>
                </div>

                <div class="card">
                    <button class="btn btn-primary" onclick="openModal('addComplaintModal')">+ Buat Laporan Baru</button>
                </div>
            </div>

            <div id="userComplaints" class="content-section hidden">
                <div class="top-bar">
                    <h1>Laporan Saya</h1>
                    <button class="btn btn-primary" onclick="openModal('addComplaintModal')">+ Tambah</button>
                </div>
                <br>

                <div class="card" style="background:white; padding:20px; border-radius:10px;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f8f9fa; text-align:left;">
                                <th style="padding:10px;">Judul</th>
                                <th style="padding:10px;">Kategori</th>
                                <th style="padding:10px;">Status</th>
                                <th style="padding:10px;">Feedback</th>
                                <th style="padding:10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr style="border-bottom:1px solid #eee;">
                                <td style="padding:10px;">{{ $report->title }}</td>
                                <td style="padding:10px;">{{ $report->category }}</td>
                                <td style="padding:10px;">
                                    <span class="status-badge status-{{ $report->status }}">
                                        {{ strtoupper($report->status) }}
                                    </span>
                                </td>
                                <td style="padding:10px;">{{ $report->feedback ?? '-' }}</td>
                                <td style="padding:10px;">
                                    @if($report->status == 'pending')
                                        <a href="{{ route('reports.edit', $report->id) }}" style="color:orange; margin-right:5px;">Edit</a>
                                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="color:red; border:none; background:none; cursor:pointer;" onclick="return confirm('Hapus?')">Hapus</button>
                                        </form>
                                    @else
                                        <span style="color:gray;">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="padding:20px; text-align:center;">Belum ada laporan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="userProfile" class="content-section hidden">
                <h1>Profil Saya</h1>
                <div class="card" style="background:white; padding:20px; margin-top:20px;">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>NIK:</strong> {{ Auth::user()->nik }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Alamat:</strong> {{ Auth::user()->alamat }}</p>
                </div>
            </div>

        </div>
    </div>

    <div id="addComplaintModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div class="modal-content" style="background:white; padding:30px; border-radius:10px; width:90%; max-width:500px; position:relative;">
            <button onclick="closeModal('addComplaintModal')" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:20px; cursor:pointer;">&times;</button>
            <h2>Buat Laporan</h2>
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" style="margin-top:20px;">
                @csrf
                <div style="margin-bottom:15px;">
                    <label>Judul</label>
                    <input type="text" name="title" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:5px;">
                </div>
                <div style="margin-bottom:15px;">
                    <label>Kategori</label>
                    <select name="category" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:5px;">
                        <option value="Infrastruktur">Infrastruktur</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Layanan Publik">Layanan Publik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label>Lokasi</label>
                    <input type="text" name="location" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:5px;">
                </div>
                <div style="margin-bottom:15px;">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" required style="width:100%; padding:8px; border:1px solid #ddd; border-radius:5px;"></textarea>
                </div>
                <div style="margin-bottom:15px;">
                    <label>Foto (Opsional)</label>
                    <input type="file" name="photo" style="width:100%;">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;">Kirim Laporan</button>
            </form>
        </div>
    </div>

    <script>
        // JS Sederhana untuk Navigasi Tab
        function showUserPage(pageId) {
            // Sembunyikan semua section
            document.getElementById('userHome').classList.add('hidden');
            document.getElementById('userComplaints').classList.add('hidden');
            document.getElementById('userProfile').classList.add('hidden');

            // Tampilkan yang dipilih
            if(pageId === 'home') document.getElementById('userHome').classList.remove('hidden');
            if(pageId === 'complaints') document.getElementById('userComplaints').classList.remove('hidden');
            if(pageId === 'profile') document.getElementById('userProfile').classList.remove('hidden');
        }

        // Modal Logic
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</body>
</html>
