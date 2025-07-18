<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/index.css') }}">
</head>
<body>
    <div class="container">
        <div>
            <h2>Daftar</h2>
            @if ($errors->any())
                <ul style="color:red;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="post" action="{{ route('register') }}">
                @csrf
                <div style="margin-bottom: 10px;">
                    <input type="text" name="name" placeholder="Nama" required style="padding: 10px; width: 300px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <input type="email" name="email" placeholder="Email" required style="padding: 10px; width: 300px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <input type="password" name="password" placeholder="Password" required style="padding: 10px; width: 300px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required style="padding: 10px; width: 300px;">
                </div>
                <button type="submit" class="btn2">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
</body>
</html>