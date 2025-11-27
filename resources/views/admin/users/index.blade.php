<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'beige-main': '#eaddc5',    // Warna Card Utama
                        'beige-dark': '#d3c0b0',    // Warna Header Tabel
                        'btn-maroon': '#803558',
                        'status-green': '#34d399',
                        'status-pink': '#f472b6',
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
<body class="min-h-screen bg-gradient-to-br from-pink-500 via-purple-500 to-slate-800 p-6 md:p-10 font-sans">

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">

            <div>
                <h1 class="text-2xl font-bold text-white drop-shadow-md mb-2">Kelola Masyarakat</h1>
                <div class="flex gap-2 text-xs font-semibold text-white">
                    <span class="bg-btn-maroon px-3 py-1 rounded-full shadow-sm border border-white/20">
                        {{ $users->count() }} Total
                    </span>
                    <span class="bg-emerald-500 px-3 py-1 rounded-full shadow-sm border border-white/20">
                        Aktif
                    </span>
                    <span class="bg-rose-500 px-3 py-1 rounded-full shadow-sm border border-white/20">
                        Nonaktif
                    </span>
                </div>
            </div>

            <div class="w-full md:w-auto flex flex-col md:flex-row gap-2">

                <div class="relative">
                    <select id="searchFilter" class="appearance-none w-full md:w-auto bg-beige-main text-gray-700 text-sm font-medium border border-beige-dark py-2.5 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-btn-maroon cursor-pointer shadow-sm">
                        <option value="name">Cari Nama</option>
                        <option value="nik">Cari NIK</option>
                        <option value="email">Cari Email</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <div class="relative w-full md:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Ketik kata kunci..."
                        class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 bg-white/90 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-btn-maroon placeholder-gray-500 shadow-sm">
                </div>
            </div>
        </div>

        @if(session('success'))
            <div id="alertBox" class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-lg flex justify-between animate-fade-in-down">
                <span class="font-medium"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button onclick="document.getElementById('alertBox').remove()" class="text-emerald-800 font-bold hover:opacity-70">&times;</button>
            </div>
        @endif

        <div class="bg-beige-main rounded-2xl shadow-2xl p-6 min-h-[500px] relative overflow-hidden border border-white/10">

            <div class="overflow-x-auto rounded-xl border border-beige-dark/50 bg-white/30">
                <table class="w-full text-sm text-left text-gray-700" id="userTable">

                    <thead class="text-xs text-gray-800 uppercase bg-beige-dark font-bold tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-4 text-left">NIK</th>
                            <th scope="col" class="px-6 py-4 text-left">Email</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-300/50">
                        @foreach($users as $user)
                        <tr class="hover:bg-white/40 transition-colors user-row group">

                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-btn-maroon text-white flex items-center justify-center text-xs font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <span class="text-sm font-bold text-gray-900 leading-tight">{{ $user->name }}</span>
                                        <span class="text-xs text-blue-600/80 font-medium mt-0.5">
                                            {{ isset($user->username) ? '@'.$user->username : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-middle font-mono text-gray-700">
                                {{ $user->nik }}
                            </td>

                            <td class="px-6 py-4 align-middle text-gray-700">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4 align-middle text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded-full border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-[11px] font-bold px-2.5 py-1 rounded-full border border-gray-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 align-middle text-center">
                                <form method="POST" action="{{ $user->is_active ? route('admin.users.deactivate', $user->id) : route('admin.users.activate', $user->id) }}" onsubmit="return confirmAction(event, '{{ $user->is_active ? 'nonaktifkan' : 'aktifkan' }}', '{{ $user->name }}')">
                                    @csrf
                                    @method('PUT')

                                    @if($user->is_active)
                                        <button type="submit" class="w-32 bg-transparent border border-status-pink text-status-pink hover:bg-status-pink hover:text-white transition-all font-semibold rounded-lg text-xs px-3 py-2 shadow-sm">
                                            <i class="fas fa-ban mr-1"></i> Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit" class="w-32 bg-transparent border border-status-green text-status-green hover:bg-status-green hover:text-white transition-all font-semibold rounded-lg text-xs px-3 py-2 shadow-sm">
                                            <i class="fas fa-check mr-1"></i> Aktifkan
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                {{ $users->links() }}
            </div>

            <div class="mt-8 pt-4 border-t border-beige-dark/30">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-btn-maroon font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    @vite('resources/js/manage_users.js')
</body>
</html>
