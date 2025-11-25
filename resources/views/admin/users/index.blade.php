<div class="top-bar" style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Kelola User Masyarakat</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="text-decoration:none; padding: 10px 20px; color:black; border-radius:5px;">← Kembali ke Dashboard</a>
</div>

<div class="card" style="background:white; padding:20px; border-radius:10px;">
    @if(session('success')) <div style="color:green;">{{ session('success') }}</div> @endif
    @if(session('error')) <div style="color:red;">{{ session('error') }}</div> @endif

    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background:#f8f9fa; text-align:left;">
                <th style="padding:10px;">Nama</th>
                <th style="padding:10px;">NIK</th>
                <th style="padding:10px;">Email</th>
                <th style="padding:10px;">Status</th>
                <th style="padding:10px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:10px;">{{ $user->name }}</td>
                <td style="padding:10px;">{{ $user->nik }}</td>
                <td style="padding:10px;">{{ $user->email }}</td>
                <td style="padding:10px;">
                    <span class="status-badge" style="background: {{ $user->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $user->is_active ? '#155724' : '#721c24' }};">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td style="padding:10px;">
                    <form method="POST" action="{{ $user->is_active ? route('admin.users.deactivate', $user->id) : route('admin.users.activate', $user->id) }}" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger" style="background: {{ $user->is_active ? '#dc3545' : '#28a745' }}; color:white; border:none; padding:5px 10px; border-radius:3px;" onclick="return confirm('Yakin?')">
                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $users->links() }}
    </div>
</div>
