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

        <button onclick="openModal('manageReportModal')" class="bg-white text-pink-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 flex items-center gap-2 mx-auto">
            <i class="fas fa-tasks"></i> Kelola Laporan Saya
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

    <main class="px-6 md:px-12 max-w-5xl mx-auto -mt-4">

        <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">

            <div class="w-full md:w-auto">
                <h2 class="text-xl font-semibold text-white/90 mb-1">Preview Laporan (Read Only)</h2>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                    {{ count($reports) }} Laporan
                </span>
            </div>

            <div class="w-full md:w-72 relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-pink-200 group-focus-within:text-white transition-colors"></i>
                </span>
                <input type="text" id="searchReportInput" placeholder="Cari laporan..."
                    class="w-full bg-white/10 backdrop-blur-md text-white placeholder-pink-200/70 border border-white/20 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/20 transition-all shadow-sm">
            </div>
        </div>

        <div class="space-y-6" id="reportListContainer">
            @forelse ($reports as $report)
                <div class="report-item bg-card-beige rounded-2xl p-6 shadow-xl text-gray-800 relative group transition hover:shadow-2xl">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-4 gap-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 leading-tight report-title">{{ $report->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="far fa-clock mr-1"></i> {{ $report->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        @php
                            $statusColor = match($report->status) {
                                'pending' => 'bg-orange-500', 'verified' => 'bg-blue-500',
                                'on_progress' => 'bg-indigo-500', 'done' => 'bg-green-500',
                                'rejected' => 'bg-red-500', default => 'bg-gray-500'
                            };
                        @endphp
                        <span class="{{ $statusColor }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase shadow-sm report-status">
                            {{ $report->status }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line report-desc">{{ $report->description }}</p>
                    </div>

                    @if ($report->photo)
                        <div class="mb-4">
                            <p class="text-xs font-bold text-gray-500 mb-1">Bukti Foto:</p>
                            <a href="{{ asset('storage/' . $report->photo) }}" target="_blank" class="block w-full md:w-64 h-40 rounded-lg overflow-hidden border border-gray-300 relative group shadow-sm">
                                <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Bukti Laporan">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-white text-xs font-bold flex items-center">
                                        <i class="fas fa-search-plus mr-1"></i> Lihat Penuh
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if($report->feedback)
                        <div class="mt-2 bg-white/60 p-3 rounded-lg border-l-4 border-blue-500 text-sm text-gray-700">
                            <span class="font-bold text-blue-600 block mb-1">Tanggapan Petugas:</span>
                            "{{ $report->feedback }}"
                            @if ($report->admin_photo)
                                <a href="{{ asset('storage/' . $report->admin_photo) }}" target="_blank" class="text-xs text-green-600 font-bold hover:underline flex items-center mt-2">
                                    <i class="fas fa-image mr-1"></i> Lihat Foto Bukti Petugas
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-10 text-center border border-white/20" id="emptyState">
                    <p class="text-white/70">Belum ada laporan. Klik tombol "Kelola Laporan Saya" di atas.</p>
                </div>
            @endforelse

            <div id="noResultState" class="hidden bg-white/10 backdrop-blur-md rounded-2xl p-10 text-center border border-white/20">
                <i class="fas fa-search text-3xl text-white/50 mb-3"></i>
                <p class="text-white/70">Laporan tidak ditemukan.</p>
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
                <h3 class="text-white font-bold text-sm"><i class="fas fa-bell text-yellow-400 mr-2"></i> Notifikasi</h3>
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

    <div id="manageReportModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm transition-opacity" onclick="closeModal('manageReportModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl max-h-[90vh] flex flex-col rounded-2xl bg-white text-left shadow-2xl">
                <div class="p-6 bg-gradient-to-r from-pink-500 to-rose-500 rounded-t-2xl shrink-0 flex justify-between items-center">
                    <div><h3 class="text-xl font-bold text-white">Kelola Laporan</h3><p class="text-pink-100 text-xs">Buat baru atau edit laporan pending</p></div>
                    <button onclick="closeModal('manageReportModal')" class="text-white/80 hover:text-white text-xl transition-transform hover:rotate-90"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 overflow-y-auto custom-scroll bg-gray-50">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 mb-8">
                        <h4 class="text-gray-800 font-bold mb-4 border-b pb-2 flex items-center gap-2"><i class="fas fa-plus-circle text-green-500"></i> Buat Laporan Baru</h4>
                        <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Laporan</label><input type="text" name="title" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kategori</label><select name="category" class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"><option value="infrastruktur">Infrastruktur</option><option value="kebersihan">Kebersihan</option><option value="keamanan">Keamanan</option><option value="lainnya">Lainnya</option></select></div>
                                <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Lokasi</label><input type="text" name="location" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></div>
                            </div>
                            <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi</label><textarea name="description" rows="3" required class="w-full bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg p-2.5"></textarea></div>
                            <div><label class="block text-xs font-bold text-gray-600 uppercase mb-1">Foto Bukti (Opsional)</label><input type="file" name="photo" class="w-full text-xs text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"></div>
                            <button type="submit" class="w-full bg-btn-pink hover:bg-btn-hover text-white font-bold py-2.5 rounded-lg shadow-md transition-all">Kirim Laporan</button>
                        </form>
                    </div>
                    <div>
                        <h4 class="text-gray-800 font-bold mb-4 flex items-center gap-2"><i class="fas fa-edit text-orange-500"></i> Riwayat & Edit</h4>
                        <div class="space-y-3">
                            @forelse ($reports as $report)
                                <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
                                    <div class="w-12 h-12 shrink-0 bg-gray-200 rounded-lg overflow-hidden border border-gray-300">
                                        @if($report->photo) <img src="{{ asset('storage/' . $report->photo) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div> @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5"><span class="font-bold text-gray-800 text-sm truncate">{{ $report->title }}</span><span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase text-white {{ $report->status == 'pending' ? 'bg-orange-400' : 'bg-gray-400' }}">{{ $report->status }}</span></div>
                                        <p class="text-xs text-gray-500 truncate">{{ $report->description }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        @if($report->status == 'pending')
                                            <button onclick="openEditModal(this)" data-id="{{ $report->id }}" data-title="{{ $report->title }}" data-desc="{{ $report->description }}" data-loc="{{ $report->location }}" data-cat="{{ $report->category }}" data-photo="{{ $report->photo ? asset('storage/' . $report->photo) : '' }}" data-url="{{ route('reports.update', $report->id) }}" class="w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-200 transition"><i class="fas fa-edit text-xs"></i></button>
                                            <form method="POST" action="{{ route('reports.destroy', $report->id) }}" onsubmit="return confirm('Hapus laporan ini?')">@csrf @method('DELETE')<button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition"><i class="fas fa-trash text-xs"></i></button></form>
                                        @else <span class="text-[10px] text-gray-400 italic"><i class="fas fa-lock"></i></span> @endif
                                    </div>
                                </div>
                            @empty <p class="text-center text-gray-400 text-sm italic">Belum ada riwayat.</p> @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editReportModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm transition-opacity" onclick="closeModal('editReportModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 transform transition-all">
                <button onclick="closeModal('editReportModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Edit Laporan</h3>
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

    @vite('resources/js/user.js')
</body>
</html>
