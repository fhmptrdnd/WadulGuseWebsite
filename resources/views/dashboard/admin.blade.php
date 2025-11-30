<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Wadul Guse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    // Warna layout utama
                    sidebar: '#1c023b',         // Biru gelap untuk Sidebar
                    active: '#34d399',          // Hijau cerah untuk menu aktif
                    'page-bg-start': '#ec4899', // Pink untuk awal gradasi background body

                    // Warna Kartu (Beige Theme)
                    beige: {
                        DEFAULT: '#f3e8d9',     // Background kartu
                        dark: '#eaddc5',        // Border/Input
                        text: '#8d7f68',        // Teks secondary
                    },

                    // Warna Status Laporan (Badge)
                    status: {
                        pink: '#f472b6',        // Menunggu
                        blue: '#60a5fa',        // Diproses
                        green: '#34d399',       // Selesai/Verified
                    }
                }
            }
        }
    }
</script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        /* Hilangkan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Input Custom Style agar menyatu dengan background Beige */
        .form-input {
            background-color: #eaddc5;
            border: 1px solid #d4c5a8;
            color: #1f2937;
            border-radius: 0.5rem;
            padding: 0.5rem;
            width: 100%;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: 2px solid #34d399;
            background-color: #fff;
        }
    </style>
</head>
<body class="h-screen flex overflow-hidden">

    <aside class="w-64 bg-sidebar text-white flex flex-col flex-shrink-0">
        <div class="p-6">
            <h1 class="text-active text-xl font-bold tracking-wide">Admin Panel</h1>
        </div>

        <div class="flex flex-col items-center mt-2 mb-8">
            <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center text-white text-2xl font-bold mb-3 border-2 border-active">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <h2 class="font-semibold text-lg">{{ Auth::user()->name }}</h2>
            <p class="text-gray-400 text-xs uppercase tracking-wider">Administrator</p>
        </div>

        <nav class="flex-1 px-4 space-y-3">
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-active text-sidebar font-bold shadow-lg shadow-green-500/20">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Beranda</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Kelola Pengguna</span>
            </a>

            <a href="{{ route('admin.news.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-newspaper w-5 text-center"></i>
                <span>Kelola Berita</span>
            </a>

            <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-user-cog w-5 text-center"></i>
                <span>Profile Admin</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto no-scrollbar p-8 min-h-screen bg-gradient-to-b from-page-bg-start via-[#be185d] to-slate-900 text-white pb-24">

        @if (session('success'))
            <div id="alert-box" class="mb-6 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('alert-box').remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-times"></i></button>
            </div>
        @endif

        <header class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white drop-shadow-md">Dashboard Admin</h1>
                <p class="text-pink-100 text-sm mt-1">Ringkasan statistik dan pengelolaan laporan masuk</p>
            </div>
            <div class="text-right">
                <span class="text-sm text-pink-100 font-semibold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <div class="bg-beige p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-gray-700 font-semibold mb-2">Total Pengaduan</h3>
                <p class="text-4xl font-bold text-gray-800">{{ $stats['total_pengaduan'] ?? $reports->count() }}</p>
                <p class="text-beige-text text-sm mt-2">Semua laporan masuk</p>
            </div>
            <div class="bg-beige p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-gray-700 font-semibold mb-2">Menunggu</h3>
                <p class="text-4xl font-bold text-status-pink">{{ $stats['menunggu'] ?? 0 }}</p>
                <p class="text-beige-text text-sm mt-2">Belum ditangani</p>
            </div>
            <div class="bg-beige p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-gray-700 font-semibold mb-2">Diproses</h3>
                <p class="text-4xl font-bold text-status-blue">{{ $stats['diproses'] ?? 0 }}</p>
                <p class="text-beige-text text-sm mt-2">Dalam penanganan</p>
            </div>
            <div class="bg-beige p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                <h3 class="text-gray-700 font-semibold mb-2">Selesai</h3>
                <p class="text-4xl font-bold text-status-green">{{ $stats['selesai'] ?? 0 }}</p>
                <p class="text-beige-text text-sm mt-2">Telah diselesaikan</p>
            </div>
        </div>

        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Laporan Terbaru ({{ $reports->count() }})</h2>

                <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg px-4 py-2 flex items-center w-64 shadow-sm">
                    <i class="fas fa-search text-white/70 mr-2"></i>
                    <input type="text" placeholder="Cari laporan..." class="bg-transparent border-none outline-none text-sm w-full text-white placeholder-white/70">
                </div>
            </div>

            <div class="space-y-6">
                @php
                    $opds = App\Models\KategoriOpd::all();
                @endphp

                @forelse ($reports as $report)
                <div class="bg-beige rounded-2xl p-6 shadow-sm border border-transparent hover:border-beige-dark transition-all">

                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <span class="bg-status-green text-white font-bold px-3 py-1 rounded text-sm">#{{ $report->id }}</span>
                            <h3 class="text-lg font-bold text-gray-800">{{ $report->title }}</h3>
                        </div>

                        @php
                            $badgeColor = match($report->status) {
                                'pending' => 'bg-status-pink text-white',
                                'verified' => 'bg-status-green text-white',
                                'on_progress' => 'bg-status-blue text-white',
                                'done' => 'bg-status-green text-white',
                                'rejected' => 'bg-red-500 text-white',
                                default => 'bg-gray-400 text-white'
                            };
                        @endphp
                        <span class="{{ $badgeColor }} px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                            {{ $report->status }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-500 mb-4 space-y-1">
                        <p>Oleh: <span class="text-status-blue font-semibold">{{ $report->user->name }}</span> (NIK: {{ $report->user->nik }})</p>
                        <p>Lokasi: {{ $report->location ?? '-' }} | Tanggal: {{ $report->created_at->format('d M Y H:i') }}</p>
                        @if($report->prioritas && $report->prioritas != 'rendah')
                             <span class="inline-block mt-1 border border-status-pink text-status-pink text-xs px-2 py-0.5 rounded">Prioritas: {{ ucfirst($report->prioritas) }}</span>
                        @endif
                    </div>

                    <div class="mb-5">
                        <h4 class="text-status-pink font-semibold text-sm mb-1">Isi Laporan:</h4>
                        <p class="text-gray-700 leading-relaxed">{{ $report->description }}</p>

                        @if ($report->photo)
                            <a href="{{ asset('storage/' . $report->photo) }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-status-blue hover:underline">
                                <i class="fas fa-image mr-1"></i> Lihat Foto User
                            </a>
                        @endif
                    </div>

                    <div class="bg-slate-200/50 p-4 rounded-xl">
                        <p class="text-gray-800 text-sm font-semibold mb-1">
                            Ditangani OPD: <span class="font-normal">{{ $report->opd->nama_opd ?? 'Belum Ditugaskan' }}</span>
                        </p>

                        @if ($report->admin_photo)
                            <a href="{{ asset('storage/' . $report->admin_photo) }}" target="_blank" class="inline-flex items-center text-sm text-status-green font-semibold hover:underline mb-2">
                                <i class="fas fa-check-circle mr-1"></i> Bukti Penanganan Admin
                            </a>
                        @endif

                        @if($report->feedback)
                            <div class="mt-2 bg-beige-dark p-3 rounded-lg text-sm text-gray-800 italic border border-beige-text/20">
                                "{{ $report->feedback }}"
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button onclick="toggleForm('form-{{ $report->id }}')" class="bg-sidebar text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition shadow-lg shadow-gray-900/10">
                            <i class="fas fa-edit mr-2"></i> Proses Laporan
                        </button>
                    </div>

                    <div id="form-{{ $report->id }}" class="hidden mt-6 pt-6 border-t border-beige-dark">
                        <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Update Status</label>
                                    <select name="status" id="status_{{ $report->id }}" class="form-input" onchange="handleStatusChange(this, {{ $report->id }})">
                                        <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="verified" {{ $report->status == 'verified' ? 'selected' : '' }}>Verifikasi (Verified)</option>
                                        <option value="on_progress" {{ $report->status == 'on_progress' ? 'selected' : '' }}>Proses (On Progress)</option>
                                        <option value="done" {{ $report->status == 'done' ? 'selected' : '' }}>Selesai (Done)</option>
                                        <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Tolak (Rejected)</option>
                                    </select>
                                </div>

                                <div id="group-opd-{{ $report->id }}" class="hidden">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih OPD</label>
                                    <select name="opd_id" id="opd_{{ $report->id }}" class="form-input">
                                        <option value="">-- Pilih OPD --</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}" {{ $report->opd_id == $opd->id ? 'selected' : '' }}>{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="group-prio-{{ $report->id }}" class="hidden">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Prioritas</label>
                                    <select name="prioritas" id="prio_{{ $report->id }}" class="form-input">
                                        <option value="rendah" {{ $report->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ $report->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ $report->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                </div>

                                <div id="group-foto-{{ $report->id }}" class="hidden">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Upload Bukti</label>
                                    <input type="file" name="admin_photo" class="form-input text-xs">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggapan Admin</label>
                                <textarea name="feedback" id="feedback_{{ $report->id }}" rows="2" class="form-input" placeholder="Tulis pesan untuk pelapor...">{{ $report->feedback }}</textarea>
                            </div>

                            <div class="mt-4 flex justify-end gap-2">
                                <button type="button" onclick="toggleForm('form-{{ $report->id }}')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Batal</button>
                                <button type="submit" class="bg-active text-sidebar px-6 py-2 rounded-lg text-sm font-bold hover:bg-emerald-400 transition">Simpan Update</button>
                            </div>
                        </form>
                    </div>

                </div>
                @empty
                    <div class="bg-beige p-10 rounded-2xl text-center border-2 border-dashed border-gray-400/50">
                        <i class="fas fa-folder-open text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600">Belum ada laporan yang masuk.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    @vite('resources/js/admin.js')
</body>

