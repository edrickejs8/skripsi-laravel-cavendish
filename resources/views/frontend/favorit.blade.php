<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit Resep - Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/favorit.css') }}">
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
        <h2 class="section-title">🔖 Favorit</h2>

        @foreach ($favorites as $resep)
            @php
                $gambar = $resep->gambar ?: 'https://via.placeholder.com/100';
            @endphp
        <div class="recipe-card">
            <div class="image-box" style="background-image: url('{{ $gambar }}');"></div>
            <div class="recipe-info">
                <h3>{{ $resep->nama_resep }}</h3>
                <p>
                    @foreach ($resep->bahans as $bahan)
                        {{ $bahan->nama_bahan }}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </p>
                <div class="meta">
                    <span>Oleh {{ $resep->user->name ?? 'Tidak diketahui' }}</span>
                    <span>Diambil dari {{ parse_url($resep->sumber, PHP_URL_HOST) }}</span>
                </div>
            </div>
            <div class="bookmark active" data-id="{{ $resep->id }}">🔖</div>
        </div>
        @endforeach
        
    </main>

    <script>
        document.querySelectorAll('.bookmark').forEach(bookmark => {
            bookmark.addEventListener('click', function () {
                const resepId = this.getAttribute('data-id');
                const el = this;

                fetch(`/favorit/toggle/${resepId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Hapus kartu dari tampilan
                    el.closest('.recipe-card').remove();
                });
            });
        });
    </script>

</body>
</html>