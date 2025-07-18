<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Resep - Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/riwayat.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
        </div>
        <nav>
            <a href="{{ route('resep') }}">Resep</a>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('profil') }}" class="active">Profil</a>
        </nav>
    </header>

    <main class="container">
        <h2 class="section-title">⟳ Riwayat</h2>

        @if ($riwayats->isEmpty())
            <p>Belum ada riwayat capture.</p>
        @endif

        @foreach ($riwayats as $riwayat)
            <div class="recipe-card">
                <div class="image-box">
                    <img src="{{ asset('storage/' . $riwayat->gambar) }}" alt="Gambar" width="100" height="100">
                </div>
                <div class="recipe-info">
                    <h3>Pisang {{ ucfirst($riwayat->tingkat_kematangan) }}</h3>
                    <p>Tingkat Kematangan: {{ ucfirst($riwayat->tingkat_kematangan) }}</p>
                    <p>Saran Penyimpanan: {{ $riwayat->penyimpanan->deskripsi ?? '-' }}</p>
                    <div class="meta">
                        <span>{{ $riwayat->created_at->format('d M Y H:i') }}</span>
                        <span>Capture oleh {{ Auth::user()->name }}</span>
                    </div>
                </div>
                <div class="bookmark">🔖</div>
            </div>
        @endforeach

    </main>
</body>
</html>