{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
</head>
<body>
    <div class="container">

        @if (session('error'))
            <div style="color:red">
                {{ session('error') }}
            </div>
        @endif

        <h1>Wadul Guse</h1>

        @if (Route::has('login'))
            <div class="action-buttons">
                <a href="{{ route('login') }}" class="login-btn">
                    Login
                </a>

                <a href="{{ route('register') }}" class="register-btn">
                    Register
                </a>
            </div>
        @endif
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wadul Guse - Sistem Pengaduan Jember</title>
    <style>
        /* ... (Copy semua CSS dari kode yang kamu kirim di sini) ... */
        /* Tambahan CSS agar pesan error Laravel terlihat */
        .alert-danger { color: red; font-size: 12px; margin-bottom: 10px; display: block; }

        /* Paste CSS lengkap dari kodemu di sini */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .landing-container { display: flex; min-height: 100vh; max-width: 1400px; margin: 0 auto; background: white; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .slide-section { flex: 1; position: relative; overflow: hidden; }
        .slide { display: none; width: 100%; height: 100%; object-fit: cover; }
        .slide.active { display: block; }
        .slide-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 30px; }
        .slide-overlay h2 { font-size: 28px; margin-bottom: 10px; }
        .slide-dots { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; }
        .dot { width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: 0.3s; }
        .dot.active { background: white; width: 30px; border-radius: 6px; }
        .login-section { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #f8f9fa; }
        .login-box { width: 100%; max-width: 400px; }
        .logo-container { text-align: center; margin-bottom: 30px; }
        .logo-container h1 { color: #667eea; font-size: 24px; margin-bottom: 5px; }
        .logo-container p { color: #666; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: 0.3s; }
        .form-group input:focus { outline: none; border-color: #667eea; }
        .btn { width: 100%; padding: 12px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .toggle-text { text-align: center; margin-top: 20px; color: #666; }
        .toggle-text a { color: #667eea; text-decoration: none; font-weight: 600; }
        .hidden { display: none !important; }

        @media (max-width: 968px) { .landing-container { flex-direction: column; } .slide-section { min-height: 300px; } }
    </style>
</head>
<body>
    <div id="landingPage" class="landing-container">
        <div class="slide-section">
            <div class="slide active" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://asset-2.tstatic.net/surabaya/foto/bank/images/alun-alun-jember_20180529_133119.jpg') center/cover;">
                <div class="slide-overlay">
                    <h2>Alun-alun Kabupaten Jember</h2>
                    <p>Pusat kegiatan masyarakat</p>
                </div>
            </div>
            <div class="slide" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://asset.kompas.com/crops/K_w-1_s-1_s-1/0x0:0x0/750x500/data/photo/2022/09/17/6325395222d75.jpg') center/cover;">
                <div class="slide-overlay">
                    <h2>Wisata Jember</h2>
                    <p>Keindahan alam yang memukau</p>
                </div>
            </div>

            <div class="slide-dots">
                <div class="dot active" onclick="changeSlide(0)"></div>
                <div class="dot" onclick="changeSlide(1)"></div>
            </div>
        </div>

        <div class="login-section">
            <div class="login-box">
                <div class="logo-container">
                    <h1>Wadul Guse</h1>
                    <p>Sistem Pengaduan Masyarakat Kabupaten Jember</p>
                </div>

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    @if($errors->any())
                        <div class="alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="remember" id="remember"> <label for="remember" style="display:inline;">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Masuk</button>
                    <div class="toggle-text">
                        Belum punya akun? <a href="#" onclick="toggleRegister()">Daftar disini</a>
                    </div>
                </form>

                <form id="registerForm" class="hidden" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Buat Username" required>
                    </div>
                    <div class="form-group">
                        <label>NIK (16 Digit)</label>
                        <input type="text" name="nik" maxlength="16" placeholder="NIK" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="nomor_telepon" placeholder="08xx" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" placeholder="Alamat Lengkap" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <div class="toggle-text">
                        Sudah punya akun? <a href="#" onclick="toggleRegister()">Login disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script untuk Slider dan Toggle Login/Register
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        function changeSlide(index) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        setInterval(() => {
            let next = (currentSlide + 1) % slides.length;
            changeSlide(next);
        }, 5000);

        function toggleRegister() {
            event.preventDefault();
            document.getElementById('loginForm').classList.toggle('hidden');
            document.getElementById('registerForm').classList.toggle('hidden');
        }
    </script>
</body>
</html>
