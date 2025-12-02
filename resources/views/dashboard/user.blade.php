<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Saya - Wadul Guse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'page-bg-start': '#ec4899',
                        'page-bg-end': '#1e3a8a',
                        'card-beige': '#ebdccb',
                        'btn-pink': '#fb7185',
                        'btn-hover': '#f43f5e',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @keyframes swing {
            0% { transform: rotate(0deg); } 20% { transform: rotate(15deg); }
            40% { transform: rotate(-10deg); } 60% { transform: rotate(5deg); }
            80% { transform: rotate(-5deg); } 100% { transform: rotate(0deg); }
        }
        .bell-swing:hover { animation: swing 0.5s ease-in-out; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

        .dark-pagination nav div[class*="flex"] { justify-content: center; }
        .dark-pagination span[aria-current="page"] span { background-color: #fb7185 !important; color: white !important; border-color: #fb7185 !important; }
        .dark-pagination a { background-color: rgba(255,255,255,0.1) !important; color: white !important; border-color: rgba(255,255,255,0.2) !important; }
        .dark-pagination a:hover { background-color: rgba(255,255,255,0.3) !important; }
        .dark-pagination span { color: rgba(255,255,255,0.7) !important; background-color: transparent !important; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-page-bg-start via-[#be185d] to-slate-900 text-white pb-24">

    <nav class="absolute top-0 right-0 p-4 md:p-6 flex gap-3 z-20">
        <a href="{{ route('news.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold transition flex items-center gap-2">
            <i class="fas fa-newspaper"></i> Berita
        </a>
        <a href="{{ route('profile.show') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold transition flex items-center gap-2">
            <i class="fas fa-user"></i> Profil
        </a>
    </nav>

    <header class="pt-24 pb-12 px-6 text-center relative">
        <h1 class="text-3xl md:text-4xl font-bold mb-2 drop-shadow-md">Selamat Datang di Wadul Guse</h1>
        <p class="text-pink-100 text-sm md:text-base font-light mb-6">Sampaikan aspirasi Anda dengan mudah.</p>
        <p class="text-white/90 font-medium mb-8">
            Halo, <span class="font-bold border-b-2 border-white/40 pb-0.5">{{ Auth::user()->name }}</span>!
        </p>

        <button onclick="openModal('createReportModal')" class="bg-white text-pink-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 flex items-center gap-2 mx-auto">
            <i class="fas fa-plus-circle"></i> Buat Laporan Baru
        </button>

        @if (session('success'))
            <div class="mt-6 bg-green-500/80 backdrop-blur-sm text-white px-4 py-2 rounded-lg inline-block shadow-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mt-6 bg-red-500/80 backdrop-blur-sm text-white px-4 py-2 rounded-lg inline-block shadow-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif
    </header>

    <main class="px-6 md:px-12 max-w-6xl mx-auto -mt-4">

        <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
            <div class="w-full md:w-auto">
                <h2 class="text-xl font-semibold text-white/90 mb-1">Galeri Laporan Saya</h2>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                    {{ $reports->total() }} Laporan
                </span>
            </div>

            <div class="w-full md:w-72 relative group">
                <form action="{{ route('dashboard') }}" method="GET">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-pink-200 group-focus-within:text-white transition-colors"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan & Enter..."
                        class="w-full bg-white/10 backdrop-blur-md text-white placeholder-pink-200/70 border border-white/20 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/20 transition-all shadow-sm">
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4" id="reportListContainer">
            @forelse ($reports as $report)
                <div onclick="openViewModal(this)"
                    class="report-item bg-card-beige rounded-xl p-3 shadow-md hover:shadow-lg cursor-pointer transition-all duration-300 relative group flex gap-4 items-start border border-white/20 hover:-translate-y-1"

                    data-id="{{ $report->id }}"
                    data-title="{{ $report->title }}"
                    data-date="{{ $report->created_at->format('d M Y H:i') }}"
                    data-status="{{ $report->status }}"
                    data-category="{{ $report->category }}"
                    data-location="{{ $report->location }}"
                    data-desc="{{ $report->description }}"
                    data-photo="{{ $report->photo ? asset('storage/' . $report->photo) : '' }}"
                    data-feedback="{{ $report->feedback }}"
                    data-admin-photo="{{ $report->admin_photo ? asset('storage/' . $report->admin_photo) : '' }}"
                    data-edit-url="{{ route('reports.update', $report->id) }}"
                    data-delete-url="{{ route('reports.destroy', $report->id) }}"
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
                                'pending' => 'bg-orange-500', 'verified' => 'bg-blue-500',
                                'on_progress' => 'bg-indigo-500', 'done' => 'bg-green-500',
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
                                <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-1 report-title pr-2">{{ $report->title }}</h3>
                                <small class="text-[10px] text-gray-500 shrink-0 whitespace-nowrap">{{ $report->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="text-[10px] text-gray-500 mb-2 flex items-center gap-2">
                                <span class="bg-white/50 px-1.5 py-0.5 rounded border border-gray-300 truncate report-status">{{ ucfirst($report->category) }}</span>
                                <span class="truncate max-w-[100px]"><i class="fas fa-map-marker-alt mr-1"></i> {{ $report->location }}</span>
                            </div>

                            <p class="text-xs text-gray-700 line-clamp-2 leading-relaxed report-desc">{{ $report->description }}</p>
                        </div>

                        @if($report->feedback)
                            <div class="flex items-center gap-1 text-[10px] text-blue-600 font-bold mt-auto">
                                <i class="fas fa-reply"></i> Ada balasan petugas
                            </div>
                        @endif
                    </div>

                    <div class="absolute right-2 bottom-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-chevron-circle-right text-gray-400"></i>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white/10 backdrop-blur-md rounded-2xl p-10 text-center border border-white/20">
                    @if(request('search'))
                        <i class="fas fa-search text-3xl text-white/50 mb-3"></i>
                        <p class="text-white/70">Laporan "{{ request('search') }}" tidak ditemukan.</p>
                    @else
                        <p class="text-white/70">Belum ada laporan.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <div class="mt-8 px-4 py-3 flex justify-center">
            <div class="dark-pagination">
                {{ $reports->links() }}
            </div>
        </div>
    </main>

    <div class="fixed bottom-6 right-6 z-40 group">
        @if(Auth::user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-600 text-white text-[10px] flex items-center justify-center rounded-full border-2 border-slate-900 z-50 font-bold animate-bounce">
                {{ Auth::user()->unreadNotifications->count() }}
            </span>
        @endif
        <button onclick="toggleNotification()" class="w-14 h-14 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300 bell-swing border-2 border-white/30">
            <i class="fas fa-bell text-2xl text-white"></i>
        </button>
    </div>

    <div id="notificationModal" class="fixed bottom-24 right-6 z-40 hidden w-80 md:w-96 origin-bottom-right transition-all duration-300 transform scale-90 opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-slate-800 p-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-sm">Notifikasi</h3>
                <button onclick="toggleNotification()" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            <div class="max-h-80 overflow-y-auto custom-scroll bg-gray-50 p-2">
                @forelse (Auth::user()->unreadNotifications as $notification)
                    <div class="bg-white p-3 mb-2 rounded-lg border-l-4 border-blue-500 shadow-sm">
                        <p class="text-gray-800 text-xs font-medium">{{ $notification->data['message'] ?? 'Pembaruan sistem.' }}</p>
                        <span class="text-[10px] text-gray-400 block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-400 text-sm">Tidak ada notifikasi.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="viewReportModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm transition-opacity" onclick="closeModal('viewReportModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
                <div class="relative h-48 bg-gray-200 shrink-0">
                    <img id="viewPhoto" src="" class="w-full h-full object-cover hidden">
                    <div id="viewNoPhoto" class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl opacity-50"></i><span class="text-xs mt-1">Tidak ada foto</span>
                    </div>
                    <button onclick="closeModal('viewReportModal')" class="absolute top-3 right-3 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition z-10"><i class="fas fa-times"></i></button>
                    <span id="viewStatusBadge" class="absolute bottom-3 left-3 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase"></span>
                </div>
                <div class="p-6 overflow-y-auto custom-scroll flex-1">
                    <div class="mb-4 border-b border-gray-100 pb-4">
                        <h2 id="viewTitle" class="text-xl font-bold text-gray-900 leading-tight mb-2"></h2>
                        <div class="flex flex-wrap gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1"><i class="far fa-clock"></i> <span id="viewDate"></span></span>
                            <span class="flex items-center gap-1"><i class="fas fa-tag"></i> <span id="viewCategory"></span></span>
                            <span class="flex items-center gap-1"><i class="fas fa-map-marker-alt"></i> <span id="viewLocation"></span></span>
                        </div>
                    </div>
                    <div class="mb-6"><h4 class="text-xs font-bold text-gray-400 uppercase mb-1">Deskripsi</h4><p id="viewDesc" class="text-gray-700 text-sm leading-relaxed whitespace-pre-line"></p></div>
                    <div id="viewFeedbackSection" class="hidden mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <h4 class="text-xs font-bold text-blue-600 uppercase mb-1 flex items-center gap-1"><i class="fas fa-reply"></i> Tanggapan Petugas</h4>
                        <p id="viewFeedback" class="text-gray-700 text-sm italic mb-2"></p>
                        <div id="viewAdminPhotoContainer" class="hidden mt-2 pt-2 border-t border-blue-200">
                            <span class="text-xs text-gray-500 block mb-1">Bukti Penyelesaian:</span>
                            <a id="viewAdminPhotoLink" href="#" target="_blank" class="block w-24 h-16 rounded-lg overflow-hidden border border-blue-300 relative group">
                                <img id="viewAdminPhoto" src="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition"></div>
                            </a>
                        </div>
                    </div>
                    <div id="viewActionButtons" class="flex gap-3 pt-2 hidden">
                        <button id="btnEditFromView" class="flex-1 bg-orange-100 text-orange-700 font-bold py-2.5 rounded-lg hover:bg-orange-200 transition text-sm flex items-center justify-center gap-2"><i class="fas fa-edit"></i> Edit</button>
                        <form id="formDeleteFromView" method="POST" action="" onsubmit="return confirm('Hapus laporan ini permanen?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 text-red-700 font-bold py-2.5 rounded-lg hover:bg-red-200 transition text-sm flex items-center justify-center gap-2"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createReportModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm transition-opacity" onclick="closeModal('createReportModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-100 shrink-0 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-plus-circle text-green-500"></i> Buat Laporan Baru</h3>
                    <button onclick="closeModal('createReportModal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="p-6 overflow-y-auto custom-scroll">
                    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Laporan</label><input type="text" name="title" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kategori</label><select name="category" class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"><option value="infrastruktur">Infrastruktur</option><option value="kebersihan">Kebersihan</option><option value="keamanan">Keamanan</option><option value="lainnya">Lainnya</option></select></div>
                            <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Lokasi</label><input type="text" name="location" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi</label><textarea name="description" rows="4" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></textarea></div>
                        <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Foto Bukti (Opsional)</label><input type="file" name="photo" class="w-full text-xs text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"></div>
                        <div class="pt-2"><button type="submit" class="w-full bg-btn-pink hover:bg-btn-hover text-white font-bold py-2.5 rounded-lg shadow-md transition-all">Kirim Laporan</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editReportModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm transition-opacity" onclick="closeModal('editReportModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-100 shrink-0 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Edit Laporan</h3>
                    <button onclick="closeModal('editReportModal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="p-6 overflow-y-auto custom-scroll">
                    <form id="editReportForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                        @csrf @method('PUT')
                        <div><label class="block text-xs font-bold text-gray-600 mb-1">Judul</label><input type="text" name="title" id="editTitle" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm text-gray-800"></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label class="block text-xs font-bold text-gray-600 mb-1">Kategori</label><select name="category" id="editCategory" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm text-gray-800"><option value="infrastruktur">Infrastruktur</option><option value="kebersihan">Kebersihan</option><option value="keamanan">Keamanan</option><option value="lainnya">Lainnya</option></select></div>
                            <div><label class="block text-xs font-bold text-gray-600 mb-1">Lokasi</label><input type="text" name="location" id="editLocation" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm text-gray-800"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-gray-600 mb-1">Deskripsi</label><textarea name="description" id="editDescription" rows="3" required class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm text-gray-800"></textarea></div>
                        <div id="editPhotoContainer" class="hidden mb-2"><label class="block text-xs font-bold text-gray-600 mb-1">Foto Saat Ini</label><div class="w-full h-32 rounded-lg overflow-hidden border border-gray-300 bg-gray-100"><img id="editPhotoPreview" src="" class="w-full h-full object-cover"></div></div>
                        <div><label class="block text-xs font-bold text-gray-600 mb-1">Ganti Foto (Opsional)</label><input type="file" name="photo" class="w-full text-xs text-gray-500 border border-gray-300 rounded-lg p-1 bg-gray-50"></div>
                        <div class="flex gap-2 pt-2"><button type="button" onclick="closeModal('editReportModal')" class="w-1/2 py-2 border border-gray-300 rounded-lg text-gray-600 text-sm font-bold hover:bg-gray-100">Batal</button><button type="submit" class="w-1/2 py-2 bg-orange-500 text-white rounded-lg text-sm font-bold hover:bg-orange-600 shadow-md">Simpan</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/user.js')
</body>
</html>
