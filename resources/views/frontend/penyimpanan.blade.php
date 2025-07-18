<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cavendish! - Cara Penyimpanan</title>
    <link rel="stylesheet" href="{{ asset('frontend/home.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
        </div>
        <nav>
            <a href="{{ route('resep') }}">Resep</a>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('profil') }}">Profil</a>
        </nav>
    </header>
    
    <div class="container">
        <h1 style="text-align: center; margin-top: 20px;">Cara Penyimpanan</h1>

        <div class="result-box" style="margin-top: 30px;">
            <p><strong>Tingkat Kematangan:</strong> {{ $penyimpanan->tingkat_kematangan }}</p>
            <p><strong>Deskripsi:</strong></p>
            <div style="white-space: pre-line;">{{ $penyimpanan->deskripsi }}</div>
        </div>
    </div>
</body>
</html>