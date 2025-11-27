<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsItem->judul_berita }} - Wadul Guse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'page-dark': '#1e293b',
                        'card-beige': '#eaddc5',    // Warna Beige Kartu
                        'accent-pink': '#fb7185',   // Warna Aksen
                        'text-dark': '#1f2937',     // Warna Teks Utama
                        'text-brown': '#78350f',    // Warna Teks Sekunder
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Typography untuk konten berita agar enak dibaca */
        .prose-custom {
            line-height: 1.8;
            font-size: 1.05rem;
        }
        .prose-custom p {
            margin-bottom: 1.5em;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#4c1d95] to-[#1e293b] p-4 md:p-8 flex justify-center">

    <div class="w-full max-w-4xl">

        <div class="mb-6">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 px-5 py-2.5 rounded-full text-sm font-semibold transition-all transform hover:-translate-x-1 shadow-lg">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
            </a>
        </div>

        <div class="bg-card-beige rounded-3xl overflow-hidden shadow-2xl relative">

            <div class="relative w-full h-64 md:h-96 bg-gray-300 group">
                @if ($newsItem->gambar_thumbnail)
                    <img src="{{ asset('storage/' . $newsItem->gambar_thumbnail) }}" alt="{{ $newsItem->judul_berita }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-80"></div>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-slate-200 text-slate-400">
                        <i class="far fa-image text-6xl mb-2 opacity-50"></i>
                        <span class="font-semibold">Tidak ada gambar</span>
                    </div>
                @endif
            </div>

            <div class="relative px-6 md:px-10 pb-10 -mt-20">

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border border-gray-100 mb-8">
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3 font-medium">
                        <span class="bg-accent-pink text-white px-3 py-1 rounded-md text-xs font-bold shadow-sm flex items-center gap-1">
                            <i class="far fa-calendar-alt"></i> {{ $newsItem->tanggal_dibuat->format('d M Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="far fa-clock"></i> {{ $newsItem->tanggal_dibuat->format('H:i') }} WIB
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                        {{ $newsItem->judul_berita }}
                    </h1>

                    <div class="flex items-center gap-3 border-t border-gray-100 pt-4 mt-4">
                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-lg">
                            {{ substr($newsItem->admin->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Ditulis Oleh</span>
                            <span class="text-sm font-bold text-gray-800">{{ $newsItem->admin->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="prose-custom text-gray-800 whitespace-pre-line text-justify md:text-left px-2">
                    {!! $newsItem->konten !!}
                </div>

                <div class="mt-10 pt-8 border-t border-gray-400/20 flex justify-center">
                    <p class="text-text-brown text-sm italic opacity-70">
                        Terima kasih telah membaca informasi terbaru dari Wadul Guse.
                    </p>
                </div>

            </div>
        </div>

        <div class="text-center mt-8 text-white/40 text-sm">
            &copy; {{ date('Y') }} Wadul Guse. All rights reserved.
        </div>

    </div>

</body>
</html>
