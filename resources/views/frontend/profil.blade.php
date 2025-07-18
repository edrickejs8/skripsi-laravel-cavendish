<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/profil.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
        </div>
        <nav>
            <a href="{{ route('resep') }}">Resep</a>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('profil') }}" class="active">Profile</a>
        </nav>
    </header>

    <main class="profile-container">
        <div class="profile-box">
            @if (Auth::user()->photo_path)
                <img src="{{ asset(Auth::user()->photo_path) }}" alt="Foto Profil" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
            @else
                 <div class="photo-placeholder">X</div>
            @endif
            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                <div class="action-buttons">
                    <a href="{{ route('profil.edit') }}">
                        <button>Edit Profil</button>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Keluar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="profile-options">
            <a href="{{ route('riwayat') }}" class="option">
                <span class="icon">⟳</span>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('favorit') }}" class="option">
                <span class="icon">⭐</span>
                <span>Favorit</span>
            </a>
        </div>
    </main>
</body>
</html>