<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WadulGuse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="antialiased">

    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-pink-600 via-slate-900 to-slate-950 overflow-hidden">
        <div class="absolute top-5 left-5 select-none pointer-events-none">
            <h1 class="text-[80px] md:text-[150px] font-bold text-white/5 leading-none">Selamat<br>Datang</h1>
        </div>
        <div class="absolute bottom-10 right-5 select-none pointer-events-none">
            <h1 class="text-[80px] md:text-[150px] font-bold text-white/5 leading-none">Login</h1>
        </div>
    </div>

    <div class="min-h-screen w-full flex flex-col items-center justify-center py-10 overflow-y-auto">

        <h2 class="text-4xl font-bold text-white mb-6 z-10 drop-shadow-lg text-center">Selamat Datang</h2>

        <div class="relative z-10 w-full max-w-md p-0.5 rounded-2xl bg-gradient-to-b from-white/40 to-white/10 shadow-2xl mx-4">
            <div class="bg-white/5 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <p class="text-gray-300 text-sm text-center mb-6 font-light">Masuk ke akun Anda untuk melanjutkan</p>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    @if(session('success'))
                        <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-2 rounded-lg text-sm text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('username')
                        <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-2 rounded-lg text-sm text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    <div>
                        <label class="block text-white font-bold mb-2 ml-1 text-lg">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:ring-2 focus:ring-pink-500 focus:outline-none text-slate-800 transition-all">
                    </div>
                    <div>
                        <label class="block text-white font-bold mb-2 ml-1 text-lg">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:ring-2 focus:ring-pink-500 focus:outline-none text-slate-800 transition-all">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-slate-800 to-blue-800 text-white font-bold text-lg hover:opacity-90 transition-opacity shadow-lg border border-white/10">Masuk</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 z-10">
            <div class="bg-white/80 backdrop-blur-sm px-8 py-3 rounded-full shadow-lg">
                <p class="text-slate-800 font-medium text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-pink-600 font-bold hover:underline">Register</a>
                </p>
            </div>
        </div>

    </div>
</body>
</html>
