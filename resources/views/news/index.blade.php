<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini - Wadul Guse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'page-bg-start': '#ec4899',
                        'page-dark': '#1e293b',
                        'card-beige': '#eaddc5',
                        'accent-pink': '#fb7185',
                        'btn-dark': '#1f2937',
                        'text-brown': '#78350f',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .line-clamp-3 {
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-page-bg-start via-[#be185d] to-slate-900 text-white pb-24 p-4 md:p-8">

    <div class="max-w-6xl mx-auto">

        <div class="bg-card-beige rounded-xl p-4 md:p-5 flex flex-col md:flex-row justify-between items-center gap-4 shadow-lg mb-8 relative z-10">

            <a href="{{ route('dashboard') }}" class="bg-white border border-gray-400 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold flex items-center shadow-sm transition-transform hover:-translate-x-1 whitespace-nowrap">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>

            <h1 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide hidden md:block">Berita Terkini</h1>

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64 group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-accent-pink transition-colors"></i>
                    </span>
                    <input type="text" id="searchNewsPublic" placeholder="Cari berita..."
                        class="w-full py-2 pl-10 pr-4 text-sm text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-pink focus:border-transparent shadow-inner transition-all">
                </div>

                <span class="bg-accent-pink text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md whitespace-nowrap text-center">
                    <span id="newsCountDisplay">{{ $news->count() }}</span> Berita
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="newsGridContainer">

            @forelse ($news as $item)
                <div class="news-card bg-card-beige rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group flex flex-col h-full">

                    <div class="relative h-48 overflow-hidden bg-gray-300 shrink-0">
                        @if ($item->gambar_thumbnail)
                            <img src="{{ asset('storage/' . $item->gambar_thumbnail) }}" alt="Thumbnail" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-300 text-slate-500 flex-col"><i class="fas fa-image text-4xl mb-2 opacity-50"></i><span class="text-xs font-semibold">No Image</span></div>
                        @endif
                        <div class="absolute bottom-3 left-3 bg-accent-pink text-white text-[10px] font-bold px-3 py-1.5 rounded-md shadow-md flex items-center gap-1">
                            <i class="far fa-calendar-alt"></i> {{ $item->tanggal_dibuat->format('d M Y') }}
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h2 class="text-lg font-bold text-gray-900 leading-tight mb-3 group-hover:text-pink-600 transition-colors">
                            <a href="{{ route('news.show', $item->slug) }}" class="news-title">
                                {{ $item->judul_berita }}
                            </a>
                        </h2>

                        <div class="news-content text-text-brown text-sm leading-relaxed mb-4 line-clamp-3 flex-grow">
                            {{ strip_tags($item->konten) }}
                        </div>

                        <div class="pt-4 border-t border-gray-400/30 flex justify-between items-center mt-auto">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider">Oleh:</span>
                                <span class="text-xs font-bold text-gray-800">{{ $item->admin->name }}</span>
                            </div>
                            <a href="{{ route('news.show', $item->slug) }}" class="bg-btn-dark hover:bg-gray-800 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2 transition-all hover:scale-105">
                                <i class="far fa-eye"></i> Baca
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm mb-4"><i class="far fa-newspaper text-4xl text-white/50"></i></div>
                    <h3 class="text-white text-xl font-bold mb-2">Belum ada berita</h3>
                </div>
            @endforelse

        </div>

        <div id="noSearchResult" class="hidden flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm mb-4">
                <i class="fas fa-search text-3xl text-white/50"></i>
            </div>
            <h3 class="text-white text-xl font-bold mb-2">Berita tidak ditemukan</h3>
            <p class="text-white/60">Coba kata kunci lain.</p>
        </div>

    </div>

    @vite('resources/js/news_user.js')
</body>
</html>
