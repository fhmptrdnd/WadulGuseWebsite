<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    </head>
<body>
    <div class="main-content" style="padding: 30px;">
        <div class="top-bar" style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Profil Pengguna</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="text-decoration:none; padding: 10px 20px; color:black; border-radius:5px;">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px;">{{ session('success') }}</div>
        @endif

        <div class="card" style="background:white; padding:30px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 20px; color:black;">Informasi Akun</h3>

            <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>NIK:</strong> {{ $user->nik }}</p>
            <p><strong>No. Telepon:</strong> {{ $user->nomor_telepon }}</p>
            <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
            <p style="margin-top: 10px;"><strong>Status:</strong> <span style="color: {{ $user->is_active ? 'green' : 'red' }}; font-weight: bold;">{{ $user->is_active ? 'Aktif' : 'Dinonaktifkan' }}</span></p>

            <button onclick="openModal('editProfileModal')" class="btn btn-primary" style="margin-top: 20px; padding: 10px 20px;">
                Edit Profil
            </button>
        </div>
    </div>

    <div id="editProfileModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div class="modal-content" style="background:white; padding:30px; border-radius:10px; width:90%; max-width:500px; position:relative;">
            <button onclick="closeModal('editProfileModal')" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:20px; cursor:pointer;">&times;</button>
            <h2>Edit Detail Profil</h2>

            <form method="POST" action="{{ route('profile.update') }}" style="margin-top: 20px;">
                @csrf
                @method('PUT')
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div>
                <div class="form-group"><label>Username</label><input type="text" name="username" value="{{ old('username', $user->username) }}" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
                <div class="form-group"><label>No. Telepon</label><input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}"></div>
                <div class="form-group"><label>Alamat</label><textarea name="alamat">{{ old('alamat', $user->alamat) }}</textarea></div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="padding:15px 20px;">
        @csrf
        <button type="submit" style="background-color: white; color: black; padding: 5px; text-decoration: none; border: 1px solid black; border-radius: 5px; margin-left: 10px; font-size:0.8rem;">Keluar</button>
    </form>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</body>
</html>
