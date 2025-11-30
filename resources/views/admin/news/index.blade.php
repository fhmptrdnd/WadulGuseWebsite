<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'page-bg-start': '#ec4899',
                        'beige-main': '#eaddc5',
                        'beige-dark': '#d3c0b0',
                        'btn-maroon': '#803558',
                        'btn-green': '#34d399',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        /* Custom Scrollbar untuk Modal */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d3c0b0; /* Warna beige gelap sesuai tema */
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #803558; /* Warna maroon saat hover */
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-page-bg-start via-[#be185d] to-slate-900 text-white pb-24">

    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white drop-shadow-md mb-2">Manajemen Berita</h1>
                <div class="flex gap-2 text-xs font-semibold text-white items-center">
                    <a href="{{ route('dashboard') }}" class="bg-white/90 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow-md flex items-center transition-all text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <button onclick="openModal('createNewsModal')" class="bg-emerald-600 hover:bg-emerald-500 px-3 py-1 rounded-full shadow-sm border border-white/20 transition-colors flex items-center gap-1 cursor-pointer">
                        <i class="fas fa-plus-circle text-[10px]"></i> Tambah Baru
                    </button>

                    <span class="bg-btn-maroon px-3 py-1 rounded-full shadow-sm border border-white/20">
                        {{ $news->count() }} Total
                    </span>
                </div>
            </div>
            <div class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fas fa-search text-gray-400"></i></span>
                <input type="text" id="newsSearchInput" placeholder="Cari judul berita..." class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 bg-white/90 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-btn-maroon placeholder-gray-500 shadow-sm">
            </div>
        </div>

        @if(session('success'))
            <div id="alertBox" class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-lg flex justify-between">
                <span class="font-medium"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button onclick="document.getElementById('alertBox').remove()" class="text-emerald-800 font-bold hover:opacity-70">&times;</button>
            </div>
        @endif

        <div class="bg-beige-main rounded-2xl shadow-2xl p-6 min-h-[500px] relative overflow-hidden border border-white/10">
            <h2 class="text-xl text-gray-800 font-bold mb-4 pl-1 border-l-4 border-btn-maroon leading-tight">Daftar Berita Terbaru</h2>

            <div class="flex flex-col gap-4" id="newsContainer">
                @forelse ($news as $item)
                <div class="news-item bg-white/40 hover:bg-white/60 border border-beige-dark/50 rounded-xl p-4 transition-all duration-300 flex flex-col md:flex-row gap-4 relative group">
                    <div class="w-full md:w-48 h-32 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 border border-gray-300">
                        @if ($item->gambar_thumbnail)
                            <img src="{{ asset('storage/' . $item->gambar_thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 flex-col"><i class="fas fa-image text-2xl"></i></div>
                        @endif
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="news-title text-lg font-bold text-gray-900 mb-1">{{ $item->judul_berita }}</h3>
                            <p class="text-xs text-gray-500 mb-2 font-medium flex items-center gap-2">
                                <span class="bg-gray-200 px-2 py-0.5 rounded text-gray-600">{{ $item->tanggal_dibuat->format('d M Y') }}</span>
                                <span>{{ $item->admin->name }}</span>
                            </p>
                            <p class="text-sm text-gray-700 leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($item->konten), 150) }}</p>
                        </div>

                        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-300/50">
                            <button
                                onclick="openEditModal(this)"
                                data-id="{{ $item->id }}"
                                data-title="{{ $item->judul_berita }}"
                                data-content="{{ $item->konten }}"
                                data-image="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : '' }}"
                                data-update-url="{{ route('admin.news.update', $item->id) }}"
                                class="bg-white border border-orange-400 text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all">
                                <i class="far fa-edit"></i> Edit
                            </button>

                            <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}" onsubmit="return confirmDelete(event)">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-white border border-red-500 text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all">
                                    <i class="far fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center py-12 text-gray-600">Belum ada berita.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="createNewsModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeModal('createNewsModal')"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-beige-main text-left shadow-2xl transition-all w-full max-w-lg border-t-4 border-btn-green p-6 md:p-8">
                <button onclick="closeModal('createNewsModal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl"><i class="fas fa-times"></i></button>
                <h3 class="text-2xl font-bold text-gray-800 mb-1">Tambah Berita Baru</h3>
                <p class="text-sm text-gray-500 mb-6">Isi form di bawah untuk menambahkan berita baru</p>

                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita: <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_berita" required placeholder="Masukkan judul berita" class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-btn-green focus:bg-white placeholder-gray-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Berita: <span class="text-red-500">*</span></label>
                        <textarea name="konten" id="kontenCreate" rows="5" required placeholder="Tulis konten berita lengkap..." class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-btn-green focus:bg-white resize-none"></textarea>
                        <div class="text-xs text-blue-500 mt-1 font-medium"><span id="charCountCreate">0</span> karakter</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Thumbnail (Opsional)</label>
                        <input type="file" name="gambar_thumbnail" class="w-full text-sm text-gray-600 bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700">
                    </div>
                    <div class="flex gap-3 mt-6 pt-2">
                        <button type="button" onclick="closeModal('createNewsModal')" class="w-1/2 py-2.5 rounded-lg border-2 border-gray-400 text-gray-700 font-bold hover:bg-gray-200">Batal</button>
                        <button type="submit" class="w-1/2 py-2.5 rounded-lg bg-btn-green text-white font-bold hover:bg-emerald-500 shadow-md">Simpan Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editNewsModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeModal('editNewsModal')"></div>

        <div class="flex min-h-full items-center justify-center p-4">

            <div class="relative w-full max-w-lg max-h-[90vh] flex flex-col rounded-2xl bg-beige-main text-left shadow-2xl transition-all border-t-4 border-blue-500">

                <div class="p-6 md:p-8 pb-0 shrink-0">
                    <button onclick="closeModal('editNewsModal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl transition-transform hover:rotate-90">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="text-2xl font-bold text-gray-800">Edit Berita</h3>
                </div>

                <div class="p-6 md:p-8 pt-4 overflow-y-auto custom-scrollbar">

                    <form id="editNewsForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita: <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_berita" id="editJudul" required
                                class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500 focus:bg-white placeholder-gray-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Berita: <span class="text-red-500">*</span></label>
                            <textarea name="konten" id="editKonten" rows="5" required
                                class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-blue-500 focus:bg-white resize-none"></textarea>
                            <div class="text-xs text-blue-500 mt-1 font-medium"><span id="charCountEdit">0</span> karakter</div>
                        </div>

                        <div id="currentImageContainer">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail Saat Ini</label>
                            <div class="w-full h-40 rounded-lg overflow-hidden border-2 border-slate-400/50 bg-gray-200 relative">
                                <img id="editImagePreview" src="" class="w-full h-full object-cover absolute inset-0">
                                <div id="noImagePlaceholder" class="hidden w-full h-full flex items-center justify-center text-gray-500 text-sm absolute inset-0">Tidak ada gambar</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Thumbnail (Opsional)</label>
                            <input type="file" name="gambar_thumbnail" class="w-full text-sm text-gray-600 bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700">
                        </div>

                        <div class="flex gap-3 mt-6 pt-2 pb-2">
                            <button type="button" onclick="closeModal('editNewsModal')" class="w-1/2 py-2.5 rounded-lg border-2 border-gray-400 text-gray-700 font-bold hover:bg-gray-200 transition-all">Batal</button>
                            <button type="submit" class="w-1/2 py-2.5 rounded-lg bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-md transition-all">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/news_base.js')
</body>
</html>
