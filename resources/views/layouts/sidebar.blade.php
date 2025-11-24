<!-- Sidebar Component - Save as: resources/views/layouts/sidebar.blade.php -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h2 style="color: #28a745;">Admin Panel</h2>
    </div>
    <div class="user-info">
        <div class="user-avatar">{{ substr(Auth::user()->name ?? 'AU', 0, 1) }}</div>
        <h3 style="margin-top:10px;">{{ Auth::user()->name ?? 'Admin Utama' }}</h3>
        <p style="font-size: 12px; color: #777;">Administrator</p>
    </div>
    <div class="nav-menu">
        <div class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" onclick="location.href='{{ route('admin.dashboard') }}'">
            🏠 Beranda
        </div>
        <div class="nav-item {{ Request::routeIs('admin.laporan') ? 'active' : '' }}" onclick="location.href='{{ route('admin.laporan') }}'">
            📢 Kelola Laporan
        </div>
        <div class="nav-item {{ Request::routeIs('admin.pengguna') ? 'active' : '' }}" onclick="location.href='{{ route('admin.pengguna') }}'">
            👥 Kelola Pengguna
        </div>
        <div class="nav-item {{ Request::routeIs('admin.berita') ? 'active' : '' }}" onclick="location.href='{{ route('admin.berita') }}'">
            📰 Kelola Berita
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; background:none; border:none; font-size:16px; text-align: left;">
                🚪 Keluar
            </button>
        </form>
    </div>
</aside>

<style>
    /* Sidebar Styles */
    .sidebar { width: 260px; background: white; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: fixed; height: 100vh; overflow-y: auto; z-index: 10; }
    .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #eee; text-align: center; }
    .user-info { margin-top: 20px; display: flex; flex-direction: column; align-items: center; }
    .user-avatar { width: 60px; height: 60px; background: #28a745; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; }
    .nav-menu { margin-top: 20px; }
    .nav-item { padding: 15px 25px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px; color: #555; }
    .nav-item:hover, .nav-item.active { background: #e8f5e9; color: #28a745; border-right: 3px solid #28a745; }
</style>
