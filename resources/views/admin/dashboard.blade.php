<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Wadul Guse</title>

    <!-- 1. Tailwind CSS (CDN untuk Styling Instan) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2. Font Awesome (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- 3. Konfigurasi Warna Custom (Sesuai Figma) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: '#0F172A', // Dark Blue/Slate untuk Sidebar
                        primary: '#4ADE80', // Hijau Terang (Active State & Verified)
                        beige: '#EADBC8',   // Warna Dasar Kartu
                        'beige-dark': '#D4C5B0',
                        accent: '#F472B6',  // Pink (Menunggu)
                    }
                }
            }
        }
    </script>

    <!-- 4. Panggil JS dari Resources (Sesuai request) -->
    @vite(['resources/js/admin.js'])

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        body { font-family: 'Segoe UI', sans-serif; background-color: #FFFFFF; }

        /* Animasi Transisi Halus */
        .fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="text-slate-800">

<div class="flex h-screen overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-sidebar text-white flex flex-col fixed h-full z-20 shadow-xl transition-transform duration-300 md:translate-x-0 -translate-x-full" id="sidebar">
        <!-- Header -->
        <div class="p-8 text-center border-b border-slate-700/50">
            <h2 class="text-xl font-bold text-primary tracking-wide">Admin Panel</h2>
        </div>

        <!-- User Profile -->
        <div class="flex flex-col items-center mt-6 mb-8">
            <div class="w-20 h-20 rounded-full bg-slate-200 text-slate-900 flex items-center justify-center text-2xl font-bold border-4 border-slate-600 mb-3 shadow-lg">
                <!-- Ambil inisial user login, fallback ke 'AU' -->
                {{ substr(Auth::user()->name ?? 'AU', 0, 2) }}
            </div>
            <h3 class="font-semibold text-lg">{{ Auth::user()->name ?? 'Admin Utama' }}</h3>
            <p class="text-xs text-slate-400">Administrator</p>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">

            <!-- Link: Beranda -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group
               {{ $page === 'dashboard' ? 'bg-primary text-slate-900 font-bold shadow-[0_0_15px_rgba(74,222,128,0.3)]' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span>Beranda</span>
            </a>

            <!-- Link: Kelola Laporan -->
            <a href="{{ route('admin.laporan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group
               {{ $page === 'laporan' ? 'bg-primary text-slate-900 font-bold shadow-[0_0_15px_rgba(74,222,128,0.3)]' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-bullhorn w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span>Kelola Laporan</span>
            </a>

            <!-- Link: Kelola Pengguna -->
            <a href="{{ route('admin.pengguna') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group
               {{ $page === 'pengguna' ? 'bg-primary text-slate-900 font-bold shadow-[0_0_15px_rgba(74,222,128,0.3)]' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-users w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span>Kelola Pengguna</span>
            </a>

            <!-- Link: Kelola Berita -->
            <a href="{{ route('admin.berita') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group
               {{ $page === 'berita' ? 'bg-primary text-slate-900 font-bold shadow-[0_0_15px_rgba(74,222,128,0.3)]' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-newspaper w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span>Kelola Berita</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 text-pink-500 hover:bg-slate-800 rounded-lg transition border border-slate-700 hover:border-pink-500 group">
                    <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 md:ml-64 bg-white h-screen overflow-y-auto p-6 md:p-8 relative">

        <!-- Mobile Header Toggle (Hanya muncul di HP) -->
        <div class="md:hidden flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Admin Panel</h2>
            <button id="sidebar-toggle" class="text-slate-800 p-2 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div role="alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm fade-in">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- ################# PAGE 1: DASHBOARD ################# -->
        @if($page === 'dashboard')
        <div class="fade-in">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Dashboard Overview</h1>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                <!-- Total Pengaduan -->
                <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Total Pengaduan</h3>
                    <div class="text-5xl font-normal text-slate-800 mb-2">{{ $stats['total_pengaduan'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Semua laporan pengaduan</p>
                </div>

                <!-- Menunggu -->
                <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Menunggu</h3>
                    <div class="text-5xl font-normal text-pink-500 mb-2">{{ $stats['menunggu'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Laporan belum ditangani</p>
                </div>

                <!-- Diproses -->
                <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Diproses</h3>
                    <div class="text-5xl font-normal text-blue-500 mb-2">{{ $stats['diproses'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Sedang dalam penanganan</p>
                </div>

                <!-- Selesai -->
                <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Selesai</h3>
                    <div class="text-5xl font-normal text-green-500 mb-2">{{ $stats['selesai'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Laporan terselesaikan</p>
                </div>

                 <!-- Total Pengguna -->
                 <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Total Pengguna</h3>
                    <div class="text-5xl font-normal text-slate-800 mb-2">{{ $stats['total_pengguna'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Pengguna terdaftar</p>
                </div>

                 <!-- Total Berita -->
                 <div class="bg-beige rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-slate-700 font-medium mb-1">Total Berita</h3>
                    <div class="text-5xl font-normal text-slate-800 mb-2">{{ $stats['total_berita'] ?? 0 }}</div>
                    <p class="text-sm text-slate-500">Berita dipublikasikan</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <h2 class="text-xl font-semibold text-slate-800 mb-4">Pengaduan Terbaru</h2>
            <div class="space-y-4">
                @forelse($recents as $recent)
                <div class="bg-beige rounded-xl p-4 flex justify-between items-center shadow-sm hover:bg-[#e4d3bf] transition">
                    <div>
                        <h4 class="font-semibold text-slate-800">{{ $recent['title'] }}</h4>
                        <p class="text-sm text-slate-500">{{ $recent['user'] }} • {{ $recent['date'] }}</p>
                    </div>
                    <span class="{{ $recent['status_class'] }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ $recent['status_label'] }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 italic">Belum ada pengaduan baru.</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- ################# PAGE 2: KELOLA LAPORAN ################# -->
        @if($page === 'laporan')
        <div class="fade-in">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Kelola Laporan Masyarakat</h1>
            <span class="bg-primary text-slate-900 text-xs font-bold px-2 py-1 rounded mb-6 inline-block">
                {{ count($reports) }} Laporan
            </span>

            <!-- Search & Filter -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="flex-1 relative group">
                    <input type="text" placeholder="Cari Nama Lengkap" class="w-full bg-beige border-none rounded-lg py-3 px-4 pl-10 focus:ring-2 focus:ring-slate-400 placeholder-slate-500 transition shadow-sm">
                    <i class="fas fa-search absolute left-3 top-3.5 text-slate-500 group-focus-within:text-slate-800"></i>
                </div>
                <div class="flex-1 relative group">
                    <input type="text" placeholder="Ketik kata kunci..." class="w-full bg-beige border-none rounded-lg py-3 px-4 pl-10 focus:ring-2 focus:ring-slate-400 placeholder-slate-500 transition shadow-sm">
                    <i class="fas fa-filter absolute left-3 top-3.5 text-slate-500 group-focus-within:text-slate-800"></i>
                </div>
            </div>

            <!-- Reports List -->
            <div class="space-y-6">
                @foreach($reports as $report)
                <div class="bg-beige rounded-2xl p-6 shadow-sm border border-transparent hover:border-slate-300 transition duration-300 relative overflow-hidden">
                    <!-- Header Kartu -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-2">
                        <div class="flex items-center gap-3">
                            <span class="bg-slate-800 text-white font-bold px-2 py-1 rounded text-sm">#{{ $report['id'] }}</span>
                            <h3 class="font-bold text-lg text-slate-900">{{ $report['title'] }}</h3>
                        </div>
                        <span class="{{ $report['status_class'] }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $report['status_label'] }}
                        </span>
                    </div>

                    <!-- Metadata -->
                    <div class="text-sm text-slate-600 mb-4 bg-white/40 p-3 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <p><i class="fas fa-user mr-2 text-slate-400"></i> <span class="text-blue-600 font-medium">{{ $report['user'] }}</span></p>
                            <p><i class="fas fa-id-card mr-2 text-slate-400"></i> NIK: {{ $report['nik'] }}</p>
                            <p><i class="fas fa-map-marker-alt mr-2 text-slate-400"></i> {{ $report['location'] }}</p>
                            <p><i class="fas fa-tag mr-2 text-slate-400"></i> {{ $report['category'] }}</p>
                        </div>
                    </div>

                    @if(isset($report['prioritas']))
                        <span class="border border-pink-400 text-pink-600 font-bold text-[10px] px-2 py-0.5 rounded-full inline-block mb-4">
                            PRIORITAS: {{ strtoupper($report['prioritas']) }}
                        </span>
                    @endif

                    <!-- Isi Laporan -->
                    <div class="mb-5">
                        <p class="text-slate-800 font-semibold text-sm mb-1">Isi Laporan:</p>
                        <p class="text-slate-600 italic leading-relaxed">"{{ $report['description'] }}"</p>
                    </div>

                    <!-- Admin Response (Jika Ada) -->
                    @if($report['response'])
                    <div class="bg-slate-200/50 rounded-lg p-4 mb-4 border border-slate-300">
                        <p class="text-sm font-bold text-slate-800 mb-2">
                            <i class="fas fa-building mr-1"></i> OPD: {{ $report['response']['opd'] }}
                        </p>
                        <div class="bg-white/80 p-3 rounded text-sm text-slate-700 border-l-4 border-primary">
                            {{ $report['response']['text'] }}
                        </div>
                        <div class="mt-2 text-xs text-blue-600 font-semibold cursor-pointer hover:underline">
                            <i class="fas fa-paperclip"></i> Lihat Bukti Penanganan
                        </div>
                    </div>
                    @endif

                    <!-- Action Button -->
                    <button class="bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-900 transition flex items-center gap-2 shadow-lg">
                        <i class="far fa-comment-alt"></i>
                        {{ $report['response'] ? 'Edit Tanggapan' : 'Beri Tanggapan' }}
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ################# PAGE 3: KELOLA PENGGUNA ################# -->
        @if($page === 'pengguna')
        <div class="fade-in">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Kelola Pengguna</h1>
            <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-6 inline-block">
                {{ count($users) }} Pengguna Terdaftar
            </span>

            <!-- Search -->
            <div class="flex gap-4 mb-8">
                <div class="relative w-full md:w-1/2 group">
                    <input type="text" placeholder="Cari Nama Lengkap atau Username" class="w-full bg-beige border-none rounded-lg py-3 px-4 pl-10 focus:ring-2 focus:ring-slate-400 placeholder-slate-500 shadow-sm transition">
                    <i class="fas fa-search absolute left-3 top-3.5 text-slate-500 group-focus-within:text-slate-800"></i>
                </div>
            </div>

            <!-- Grid Pengguna -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($users as $user)
                <div class="bg-beige rounded-2xl p-6 flex flex-col gap-4 shadow-sm hover:shadow-lg transition duration-300 relative group">
                    <div class="absolute top-4 right-4 text-slate-400 group-hover:text-slate-600 cursor-pointer">
                        <i class="fas fa-ellipsis-v"></i>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center text-slate-400 font-bold text-xl shadow-inner border border-slate-200">
                            {{ $user['initial'] }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 leading-tight">{{ $user['name'] }}</h3>
                            <p class="text-blue-600 text-sm font-medium">{{ $user['username'] }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-300/50 pt-3 space-y-2 text-sm text-slate-600">
                        <div class="flex items-center gap-3">
                            <div class="w-6 flex justify-center"><i class="fas fa-envelope text-slate-400"></i></div>
                            <span>{{ $user['email'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 flex justify-center"><i class="far fa-calendar text-slate-400"></i></div>
                            <span>Join: {{ $user['joined'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 flex justify-center"><i class="fas fa-pencil-alt text-slate-400"></i></div>
                            <span class="font-semibold text-slate-800">{{ $user['complaint_count'] }} Laporan</span>
                        </div>
                    </div>

                    <div class="mt-auto pt-2 flex gap-2">
                        <button class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 rounded text-xs font-bold hover:bg-slate-50 transition">DETAIL</button>
                        <button class="flex-1 bg-red-100 border border-red-200 text-red-600 py-2 rounded text-xs font-bold hover:bg-red-200 transition">BLOCK</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ################# PAGE 4: KELOLA BERITA ################# -->
        @if($page === 'berita')
        <div class="fade-in">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Kelola Berita</h1>

            <div class="flex flex-col items-center justify-center p-12 bg-beige rounded-2xl border-2 border-dashed border-slate-400 text-slate-500 min-h-[400px]">
                <div class="bg-white p-6 rounded-full shadow-md mb-4">
                    <i class="fas fa-newspaper text-4xl text-slate-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-700">Belum Ada Berita</h3>
                <p class="mb-6 max-w-md text-center">Anda dapat mulai menulis berita atau pengumuman untuk ditampilkan kepada pengguna aplikasi.</p>
                <button class="bg-primary text-slate-900 px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-green-400 transition transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Buat Berita Baru
                </button>
            </div>
        </div>
        @endif

        <div class="mt-12 text-center text-slate-400 text-xs">
            &copy; 2024 Admin Panel Wadul Guse. All rights reserved.
        </div>

    </main>
</div>

</body>
</html>
