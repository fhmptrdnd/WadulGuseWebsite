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
                        sidebar: '#1c023b',
                        active: '#34d399',
                        'page-bg-start': '#ec4899',
                        beige: { DEFAULT: '#f3e8d9', dark: '#eaddc5', text: '#8d7f68' },
                        status: { pink: '#f472b6', blue: '#60a5fa', green: '#34d399' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

        .dark-pagination nav div[class*="flex"] { justify-content: center; }
        .dark-pagination span[aria-current="page"] span { background-color: #34d399 !important; color: #1e293b !important; border-color: #34d399 !important; font-weight: bold; }
        .dark-pagination a { background-color: rgba(255,255,255,0.1) !important; color: white !important; border-color: rgba(255,255,255,0.2) !important; }
        .dark-pagination a:hover { background-color: rgba(255,255,255,0.3) !important; }
        .dark-pagination span { color: rgba(255,255,255,0.7) !important; background-color: transparent !important; }
    </style>
</head>
<body class="h-screen flex overflow-hidden bg-slate-900">

    <aside class="w-64 bg-sidebar text-white flex flex-col flex-shrink-0 z-20">
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
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-active text-sidebar font-bold shadow-lg">
                <i class="fas fa-home w-5 text-center"></i> <span>Beranda</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-users w-5 text-center"></i> <span>Kelola Pengguna</span>
            </a>
            <a href="{{ route('admin.news.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-newspaper w-5 text-center"></i> <span>Kelola Berita</span>
            </a>
            <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-all">
                <i class="fas fa-user-cog w-5 text-center"></i> <span>Profile Admin</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto custom-scroll p-8 min-h-screen bg-gradient-to-b from-page-bg-start via-[#be185d] to-slate-900 text-white pb-24">

        @if (session('success'))
            <div id="alert-box" class="mb-6 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm flex justify-between items-center animate-bounce">
                <div class="flex items-center"><i class="fas fa-check-circle mr-2"></i><p>{{ session('success') }}</p></div>
                <button onclick="document.getElementById('alert-box').remove()" class="text-emerald-500 hover:text-emerald-800"><i class="fas fa-times"></i></button>
            </div>
        @endif

        @if (session('error'))
            <div id="alert-box-err" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
                <div class="flex items-center"><i class="fas fa-exclamation-circle mr-2"></i><p>{{ session('error') }}</p></div>
                <button onclick="document.getElementById('alert-box-err').remove()" class="text-red-500 hover:text-red-800"><i class="fas fa-times"></i></button>
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
                <p class="text-4xl font-bold text-gray-800">{{ $stats['total_pengaduan'] ?? $reports->total() }}</p>
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
            <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
                <h2 class="text-xl font-bold text-white">Laporan Terbaru ({{ $reports->total() }})</h2>

                <div class="w-full md:w-72 relative group">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-pink-200 group-focus-within:text-white transition-colors"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan & Enter..."
                            class="w-full bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg py-2 pl-10 pr-4 text-sm text-white placeholder-white/70 focus:outline-none focus:bg-white/30 transition-all shadow-sm">
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @php $opds = App\Models\KategoriOpd::all(); @endphp

                @forelse ($reports as $report)

                @php
                    // Cek apakah sudah final
                    $isFinal = in_array($report->status, ['done', 'rejected']);
                @endphp

                <div
                    onclick="openAdminModal(this)"
                    class="bg-beige rounded-xl p-3 shadow-md hover:shadow-lg cursor-pointer transition-all duration-300 relative group flex gap-4 items-start border border-transparent hover:border-active h-auto {{ $isFinal ? 'opacity-90' : '' }}"

                    /* DATA ATTRIBUTES */
                    data-id="{{ $report->id }}"
                    data-title="{{ $report->title }}"
                    data-user="{{ $report->user->name }} (NIK: {{ $report->user->nik }})"
                    data-date="{{ $report->created_at->format('d M Y H:i') }}"
                    data-status="{{ $report->status }}"
                    data-desc="{{ $report->description }}"
                    data-location="{{ $report->location }}"
                    data-photo="{{ $report->photo ? asset('storage/' . $report->photo) : '' }}"
                    data-admin-photo="{{ $report->admin_photo ? asset('storage/' . $report->admin_photo) : '' }}"
                    data-feedback="{{ $report->feedback }}"
                    data-opd="{{ $report->opd_id }}"
                    data-opd-name="{{ $report->opd->nama_opd ?? 'Belum Ditugaskan' }}"
                    data-prioritas="{{ $report->prioritas }}"

                    /* [BARU] Data untuk JS tahu ini read-only */
                    data-is-final="{{ $isFinal ? 'true' : 'false' }}"

                    data-action="{{ route('reports.update', $report->id) }}"
                >
                    <div class="w-24 h-24 shrink-0 rounded-lg overflow-hidden bg-gray-300 relative border border-gray-400/30">
                        @if($report->photo)
                            <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-200 text-slate-400">
                                <i class="fas fa-file-alt text-2xl opacity-50"></i>
                            </div>
                        @endif

                        @php
                            $statusColor = match($report->status) {
                                'pending' => 'bg-status-pink', 'verified' => 'bg-status-green',
                                'on_progress' => 'bg-status-blue', 'done' => 'bg-status-green',
                                'rejected' => 'bg-red-500', default => 'bg-gray-500'
                            };
                        @endphp
                        <div class="absolute bottom-0 left-0 w-full {{ $statusColor }} text-white text-[9px] font-bold text-center py-0.5 uppercase tracking-wider">
                            {{ $report->status }}
                        </div>
                    </div>

                    <div class="flex-1 min-w-0 flex flex-col justify-between h-24 py-0.5">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-1 pr-2">{{ $report->title }}</h3>
                                <small class="text-[10px] text-gray-500 shrink-0 whitespace-nowrap">{{ $report->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="text-[10px] text-gray-500 mb-2 flex items-center gap-2">
                                <span class="bg-white/50 px-1.5 py-0.5 rounded border border-gray-300 truncate font-semibold"><i class="far fa-user mr-1"></i> {{ $report->user->name }}</span>
                            </div>

                            <p class="text-xs text-gray-700 line-clamp-2 leading-relaxed">{{ $report->description }}</p>
                        </div>

                        <div class="flex justify-end mt-auto">
                            @if(!$isFinal)
                                <span class="text-[10px] text-active font-bold flex items-center gap-1 group-hover:underline">Proses Laporan <i class="fas fa-arrow-right"></i></span>
                            @else
                                <span class="text-[10px] text-gray-500 font-bold flex items-center gap-1"><i class="fas fa-check-circle"></i> Lihat Detail</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full bg-beige p-10 rounded-2xl text-center border-2 border-dashed border-gray-400/50">
                        <i class="fas fa-folder-open text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600">Belum ada laporan yang masuk.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 px-4 py-3 flex justify-center">
                <div class="dark-pagination">
                    {{ $reports->links() }}
                </div>
            </div>
        </section>

    </main>

    <div id="adminProcessModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm transition-opacity" onclick="closeAdminModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[95vh] overflow-hidden">

                <div class="p-6 bg-sidebar text-white shrink-0 flex justify-between items-center border-b border-gray-700">
                    <div>
                        <h3 class="text-lg font-bold" id="modalHeaderTitle">Proses Laporan</h3>
                        <p class="text-xs text-gray-300">Detail data laporan masyarakat</p>
                    </div>
                    <button onclick="closeAdminModal()" class="text-gray-400 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div id="finalStatusAlert" class="hidden bg-gray-100 p-3 text-center border-b border-gray-200">
                    <p class="text-xs text-gray-600 font-bold"><i class="fas fa-lock mr-1"></i> Laporan ini sudah selesai/ditolak. Data tidak dapat diubah.</p>
                </div>

                <div class="flex flex-col lg:flex-row flex-1 overflow-y-auto custom-scroll">

                    <div class="lg:w-1/2 p-6 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200">
                        <div class="mb-6">
                            <span id="modalStatusBadge" class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white mb-3 uppercase"></span>
                            <h2 id="modalTitle" class="text-xl font-bold text-gray-900 mb-2 leading-tight"></h2>

                            <div class="text-xs text-gray-500 space-y-1 mb-4">
                                <p><i class="far fa-user mr-1 w-4 text-center"></i> <span id="modalUser"></span></p>
                                <p><i class="far fa-clock mr-1 w-4 text-center"></i> <span id="modalDate"></span></p>
                                <p><i class="fas fa-map-marker-alt mr-1 w-4 text-center"></i> <span id="modalLocation"></span></p>
                            </div>

                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600 font-bold">Ditangani Oleh:</span>
                                    <span id="modalOpdDisplay" class="text-xs font-bold text-blue-800"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600 font-bold">Prioritas:</span>
                                    <span id="modalPrioritasDisplay" class="text-xs font-bold text-gray-800 uppercase"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 shadow-sm">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Deskripsi Masalah</h4>
                            <p id="modalDesc" class="text-sm text-gray-700 whitespace-pre-line"></p>
                        </div>

                        <div id="modalPhotoContainer" class="hidden">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Bukti Foto Pelapor</h4>
                            <a id="modalPhotoLink" href="#" target="_blank" class="block rounded-lg overflow-hidden border border-gray-300 relative group">
                                <img id="modalPhoto" src="" class="w-full h-48 object-cover bg-gray-200 group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                    <span class="opacity-0 group-hover:opacity-100 bg-black/60 text-white text-xs px-2 py-1 rounded"><i class="fas fa-search-plus"></i> Zoom</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="lg:w-1/2 p-6 bg-white relative">
                        <div id="formDisabledOverlay" class="hidden absolute inset-0 bg-white/50 z-10 cursor-not-allowed"></div>

                        <h4 class="text-sm font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                            <i class="fas fa-tasks text-active"></i> Tindakan Admin
                        </h4>

                        <form id="adminProcessForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                            @csrf @method('PUT')

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Update Status</label>
                                <div class="relative">
                                    <select name="status" id="inputStatus" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 appearance-none focus:ring-2 focus:ring-active focus:border-active" onchange="toggleAdminFields()">
                                        <option value="pending">⏳ Pending (Menunggu)</option>
                                        <option value="verified">✅ Terverifikasi (Siap Proses)</option>
                                        <option value="on_progress">🛠 Sedang Diproses</option>
                                        <option value="done">🎉 Selesai</option>
                                        <option value="rejected">❌ Ditolak</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="groupOpdPrioritas" class="hidden space-y-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div>
                                    <label class="block text-xs font-bold text-blue-800 mb-1">Tugaskan ke OPD / Instansi</label>
                                    <select name="opd_id" id="inputOpd" class="w-full bg-white border border-blue-200 rounded-lg p-2 text-sm text-gray-800">
                                        <option value="">-- Pilih Instansi --</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->opd_id }}">{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-blue-800 mb-1">Tingkat Prioritas</label>
                                    <select name="prioritas" id="inputPrioritas" class="w-full bg-white border border-blue-200 rounded-lg p-2 text-sm text-gray-800">
                                        <option value="rendah">🟢 Rendah</option>
                                        <option value="sedang">🟡 Sedang</option>
                                        <option value="tinggi">🔴 Tinggi</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Tanggapan Admin / Feedback <span class="text-red-500 text-[10px] hidden" id="feedbackRequired">*Wajib</span></label>
                                <textarea name="feedback" id="inputFeedback" rows="4" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-active focus:border-active" placeholder="Tulis pesan balasan untuk pelapor..."></textarea>
                            </div>

                            <div id="groupAdminPhoto" class="hidden p-3 bg-green-50 rounded-lg border border-green-100">
                                <label class="block text-xs font-bold text-green-800 mb-1">Upload Bukti Penyelesaian</label>
                                <input type="file" name="admin_photo" class="w-full text-xs text-gray-500 border border-green-200 rounded-lg p-1 bg-white cursor-pointer">

                                <div id="existingAdminPhoto" class="hidden mt-2">
                                    <p class="text-[10px] text-green-600 mb-1 font-semibold">Bukti Sebelumnya:</p>
                                    <img id="imgAdminPhoto" src="" class="h-24 rounded-lg border border-green-200 object-cover">
                                </div>
                            </div>

                            <button type="submit" id="btnSubmitAdmin" class="w-full bg-active hover:bg-emerald-500 text-sidebar font-bold py-3 rounded-lg shadow-md transition-all mt-2 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/admin.js')
</body>
</html>
