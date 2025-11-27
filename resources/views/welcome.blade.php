<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WadulGuse - Platform Aspirasi Masyarakat Jember</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    @if (@session('error'))
        <div class="text-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-r from-pink-400 via-purple-500 to-blue-900">

        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center opacity-40" style="background-image: url('{{ asset('images/Jember_Landpage.png') }}');"></div>
        </div>




        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <h2 class="text-white text-lg sm:text-xl md:text-2xl font-light mb-2 sm:mb-4 tracking-wide">
                Selamat Datang di
            </h2>

            <h1 class="text-white text-5xl sm:text-6xl md:text-7xl font-bold mb-6 drop-shadow-lg">
                WadulGuse
            </h1>

            <p class="text-white/90 text-base sm:text-lg md:text-xl leading-relaxed mb-10 max-w-3xl mx-auto">
                Sebuah platform di mana Masyarakat Jember dapat menyampaikan aspirasi dan aduannya mengenai masalah, kendala, dan permasalahan lain yang terjadi di Kabupaten Jember.
            </p>

            <a href="{{ route('login') }}"
               class="inline-block bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white text-lg font-semibold px-10 py-3 rounded-full shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-pink-500/50 border border-white/20">
                Mulai
            </a>
        </div>

        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
    </div>
</body>
</html>
