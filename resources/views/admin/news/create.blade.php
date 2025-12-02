<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'beige-main': '#eaddc5',    // Warna background modal
                        'input-bg': '#d3c0b0',      // Warna background input (lebih gelap dikit)
                        'input-border': '#9ca3af',  // Warna border input
                        'btn-green': '#34d399',     // Tombol Simpan
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Backdrop Blur Effect untuk ilusi Modal */
        .backdrop-blur-custom {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="min-h-screen bg-linear-to-br from-pink-500 via-purple-500 to-slate-800 flex items-center justify-center p-4">

    <div class="w-full max-w-lg relative z-10">

        <div class="bg-beige-main rounded-2xl shadow-2xl p-6 md:p-8 relative border-t-4 border-btn-green animate-fade-in-up">

            <a href="{{ route('admin.news.index') }}" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>

            <h1 class="text-2xl font-bold text-gray-800 mb-1">Tambah Berita Baru</h1>
            <p class="text-sm text-gray-500 mb-6">Isi form di bawah untuk menambahkan berita baru</p>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="judul_berita" class="block text-sm font-semibold text-gray-700 mb-1">
                        Judul Berita: <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}" required
                        placeholder="Masukkan judul berita"
                        class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-btn-green focus:bg-white transition-all placeholder-gray-500">
                </div>

                <div>
                    <label for="konten" class="block text-sm font-semibold text-gray-700 mb-1">
                        Konten Berita: <span class="text-red-500">*</span>
                    </label>
                    <textarea name="konten" id="konten" rows="5" required
                        placeholder="Tulis konten berita lengkap..."
                        class="w-full bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:border-btn-green focus:bg-white transition-all placeholder-gray-500 resize-none">{{ old('konten') }}</textarea>

                    <div class="text-xs text-blue-500 mt-1 font-medium">
                        <span id="charCount">0</span> karakter
                    </div>
                </div>

                <div>
                    <label for="gambar_thumbnail" class="block text-sm font-semibold text-gray-700 mb-1">
                        Gambar Thumbnail (Opsional, Maks 2MB)
                    </label>
                    <input type="file" name="gambar_thumbnail" id="gambar_thumbnail"
                        class="w-full text-sm text-gray-600 bg-[#d3c0b0]/50 border-2 border-slate-400/50 rounded-lg cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-white hover:file:bg-gray-700">
                    <p class="text-xs text-blue-400 mt-1">Format: JPG, JPEG, PNG, GIF • Maksimal 2MB</p>
                </div>

                <div class="flex gap-3 mt-6 pt-2">
                    <a href="{{ route('admin.news.index') }}" class="w-1/2 text-center py-2.5 rounded-lg border-2 border-gray-400 text-gray-700 font-bold hover:bg-gray-200 transition-all">
                        Batal
                    </a>

                    <button type="submit" class="w-1/2 py-2.5 rounded-lg bg-btn-green text-white font-bold hover:bg-emerald-500 shadow-md transition-all">
                        Simpan Berita
                    </button>
                </div>

            </form>
            </div>
    </div>

    @vite('resources/js/create_news.js')
</body>
</html>
