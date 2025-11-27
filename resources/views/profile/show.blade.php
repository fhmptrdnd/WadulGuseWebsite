<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'page-bg-start': '#ec4899', // Pinkish
                        'page-bg-end': '#1e3a8a',   // Dark Blue
                        'card-beige': '#ebdccb',    // Warna dasar kartu
                        'card-info': '#8da3b1',     // Warna kotak info (biru abu)
                        'card-addr': '#d3c0b0',     // Warna kotak alamat (beige gelap)
                        'btn-maroon': '#803558',    // Warna tombol edit
                        'input-border': '#93c5fd',  // Border input modal
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-pink-500 via-purple-500 to-slate-800 flex items-center justify-center p-4 md:p-8">

    <div class="w-full max-w-6xl">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-white mb-4 md:mb-0 shadow-sm drop-shadow-md">Profil Pengguna</h1>

            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}" class="bg-white/90 hover:bg-white text-gray-800 px-4 py-2 rounded-lg shadow-md flex items-center transition-all text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500/80 hover:bg-red-500 text-white px-4 py-2 rounded-lg shadow-md transition-all text-sm font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg animate-fade-in-down">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-card-beige rounded-[2rem] shadow-2xl p-6 md:p-10 relative overflow-hidden">
            <h2 class="text-gray-800 font-medium text-lg mb-8">Informasi Akun</h2>

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-1/4 flex flex-col items-center text-center">
                    <div class="w-40 h-40 rounded-full bg-white flex items-center justify-center text-4xl text-orange-200 font-bold shadow-inner mb-4 select-none">
                        {{ substr($user->name, 0, 2) }}
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-card-info font-medium mt-1">@ {{ $user->username }}</p>

                    <div class="mt-2 px-3 py-1 rounded-full text-xs font-bold {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $user->is_active ? 'Aktif' : 'Dinonaktifkan' }}
                    </div>
                </div>

                <div class="lg:w-3/4 flex flex-col gap-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-card-info p-5 rounded-xl shadow-sm text-white flex flex-col justify-center h-28">
                            <div class="flex items-center gap-2 mb-1 text-gray-200 text-sm">
                                <i class="far fa-envelope"></i> Email
                            </div>
                            <p class="text-lg font-medium truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                        </div>

                        <div class="bg-card-info p-5 rounded-xl shadow-sm text-white flex flex-col justify-center h-28">
                            <div class="flex items-center gap-2 mb-1 text-gray-200 text-sm">
                                <i class="far fa-id-card"></i> NIK
                            </div>
                            <p class="text-lg font-medium">{{ $user->nik ?? '-' }}</p>
                        </div>

                        <div class="bg-card-info p-5 rounded-xl shadow-sm text-white flex flex-col justify-center h-28">
                            <div class="flex items-center gap-2 mb-1 text-gray-200 text-sm">
                                <i class="fas fa-phone-alt"></i> No. Telepon
                            </div>
                            <p class="text-lg font-medium">{{ $user->nomor_telepon ?? '-' }}</p>
                        </div>

                        <div class="bg-card-info p-5 rounded-xl shadow-sm text-white flex flex-col justify-center h-28">
                            <div class="flex items-center gap-2 mb-1 text-gray-200 text-sm">
                                <i class="far fa-user"></i> Bergabung Sejak
                            </div>
                            <p class="text-lg font-medium">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-card-addr p-6 rounded-xl shadow-inner text-gray-800">
                        <div class="flex items-center gap-2 mb-2 text-purple-900 font-medium">
                            <i class="fas fa-map-marker-alt"></i> Alamat
                        </div>
                        <p class="font-medium ml-6 leading-relaxed">
                            {{ $user->alamat ?? 'Belum ada alamat yang disimpan.' }}
                        </p>
                    </div>

                    <div>
                        <button onclick="openModal('editProfileModal')" class="bg-btn-maroon hover:bg-[#602040] text-white px-6 py-3 rounded-lg shadow-md transition-all flex items-center gap-2 font-medium">
                            <i class="far fa-edit"></i> Edit Profil
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" onclick="closeModal('editProfileModal')"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-card-beige text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 border-t-4 border-btn-maroon">

                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900" id="modal-title">Edit Detail Profil</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil Anda di sini</p>
                    </div>
                    <button type="button" onclick="closeModal('editProfileModal')" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full rounded-md border-2 border-input-border bg-white px-3 py-2 text-gray-900 focus:border-btn-maroon focus:outline-none shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                class="w-full rounded-md border-2 border-input-border bg-white px-3 py-2 text-gray-900 focus:border-btn-maroon focus:outline-none shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-md border-2 border-input-border bg-white px-3 py-2 text-gray-900 focus:border-btn-maroon focus:outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                            class="w-full rounded-md border-2 border-input-border bg-white px-3 py-2 text-gray-900 focus:border-btn-maroon focus:outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="w-full rounded-md border-2 border-input-border bg-white px-3 py-2 text-gray-900 focus:border-btn-maroon focus:outline-none shadow-sm" placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="closeModal('editProfileModal')"
                            class="w-full sm:w-1/2 justify-center rounded-md border border-gray-400 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:w-1/2 justify-center rounded-md bg-btn-maroon px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#602040] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @vite('resources/js/profile.js')
</body>
</html>
