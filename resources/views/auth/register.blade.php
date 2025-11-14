<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Form Pendaftaran</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Nama:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <br>

        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <br>

        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
        </div>

        <br>

        <div>
            <label for="password_confirmation">Konfirmasi Password:</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <br>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>.</p>
</body>
</html>
