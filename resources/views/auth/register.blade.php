<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WadulGuse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="antialiased">

    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-pink-600 via-slate-900 to-slate-950 overflow-hidden">
        <div class="absolute top-5 left-5 md:top-10 md:left-10 select-none pointer-events-none">
            <h1 class="text-[60px] md:text-[120px] font-bold text-white/5 leading-none">
                Selamat<br>Datang
            </h1>
        </div>

        <div class="absolute bottom-5 right-5 md:bottom-10 md:right-10 select-none pointer-events-none">
            <h1 class="text-[60px] md:text-[120px] font-bold text-white/5 leading-none text-right">
                Register
            </h1>
        </div>
    </div>

    <div class="min-h-screen w-full flex flex-col items-center justify-center py-10 overflow-y-auto">

        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 z-10 drop-shadow-lg text-center mt-10 md:mt-0">
            Selamat Datang
        </h2>

        <div class="relative z-10 w-full max-w-lg p-0.5 rounded-2xl bg-gradient-to-b from-white/30 to-transparent shadow-2xl mx-4">

            <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 md:p-8 border border-white/10 shadow-[0_8px_32px_0_rgba(0,0,0,0.36)]">

                <p class="text-gray-200 text-sm text-center mb-6 font-light tracking-wide drop-shadow-md">
                    Daftarkan akun Anda untuk melanjutkan
                </p>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('name') border-red-500 @enderror"
                            required>
                        @error('name') <span class="text-red-300 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">NIK</label>
                        <input type="number" name="nik" value="{{ old('nik') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('nik') border-red-500 @enderror"
                            required>
                        @error('nik') <span class="text-red-300 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('email') border-red-500 @enderror"
                            required>
                        @error('email') <span class="text-red-300 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('username') border-red-500 @enderror"
                            required>
                        @error('username') <span class="text-red-300 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('password') border-red-500 @enderror"
                            required>
                        @error('password') <span class="text-red-300 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('alamat') border-red-500 @enderror"
                            required>
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-1 ml-1 text-sm md:text-base drop-shadow-md">No. Telepon</label>
                        <input type="number" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 focus:bg-white/20 focus:border-pink-400 focus:ring-0 focus:outline-none text-white placeholder-gray-300 transition-all backdrop-blur-sm @error('phone') border-red-500 @enderror"
                            required>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-slate-800 to-blue-900 text-white font-bold text-lg hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200 border border-white/20">
                            Daftar
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div class="mt-8 z-10 relative mb-10">
            <div class="bg-white/80 backdrop-blur-md px-8 py-3 rounded-full shadow-xl border border-white/40">
                <p class="text-slate-800 font-medium text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-pink-600 font-bold hover:text-pink-700 transition-colors">Login</a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>
