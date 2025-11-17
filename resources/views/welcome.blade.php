<!DOCTYPE html>
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
</html>
