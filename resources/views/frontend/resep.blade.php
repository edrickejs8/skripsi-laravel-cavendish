<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep - Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/resep.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
        </div>
        <nav>
            <a href="{{ route('resep') }}" class="active">Resep</a>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('profil') }}">Profil</a>
        </nav>
    </header>

    <form action="{{ route('resep') }}" method="GET" class="search-bar">
        <input type="text" name="q" placeholder="Cari Resep..." value="{{ request('q') }}">
        <button type="submit" class="search-btn">Search</button>
    </form>

    <div class="filter-section">
        @if (isset($filter))
            <p>Menampilkan resep untuk tingkat kematangan: <strong>{{ ucfirst($filter) }}</strong></p>
        @endif
        <form action="{{ route('resep') }}" method="GET">
            <input type="text" name="q" placeholder="Cari Resep..." value="{{ request('q') }}" hidden>
            <label for="tingkat_kematangan">Filter berdasarkan tingkat kematangan:</label>
            <select name="tingkat_kematangan" id="tingkat_kematangan" onchange="this.form.submit()">
                <option value="">Semua</option>
                @php use App\Enums\TingkatKematanganEnum; @endphp
                @foreach (TingkatKematanganEnum::cases() as $case)
                    <option value="{{ $case->value }}" {{ request('tingkat_kematangan') == $case->value ? 'selected' : '' }}>
                        @switch($case)
                            @case(TingkatKematanganEnum::Mentah)
                                Mentah
                                @break
                            @case(TingkatKematanganEnum::Matang)
                                Matang
                                @break
                            @case(TingkatKematanganEnum::MatangSekali)
                                Matang Sekali
                                @break
                            @case(TingkatKematanganEnum::Busuk)
                                Busuk
                                @break
                        @endswitch
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="recipe-list">
        @if ($reseps->isEmpty())
            <p class="no-result">
                @if (request('q'))
                    Tidak ada resep ditemukan untuk pencarian "{{ request('q') }}"
                @elseif (isset($filter))
                    Tidak ada resep untuk tingkat kematangan: <strong>{{ ucfirst($filter) }}</strong>
                @else
                    Tidak ada resep ditemukan.
                @endif
            </p>
        @endif

        @foreach ($reseps as $resep)
        @php
            $gambar = $resep->gambar ?: 'https://via.placeholder.com/100';
        @endphp
        <div class="recipe-card" onclick="toggleDetails(this)">
            <div class="image-box" style="background-image: url('{{ $gambar }}');"></div>
            <div class="recipe-content">
                    <h3 class="font-bold">{{ $resep->nama_resep }}</h3>
                <p>{{ $resep->deskripsi }}</p>
                <p><strong>{{ $resep->tingkat_kematangan }}</strong></p>
                <div class="footer">
                    <span>Oleh {{ $resep->user->name ?? 'Tidak diketahui' }}</span>
                    <span>Diambil dari <a href="{{ $resep->sumber }}" target="_blank">{{ parse_url($resep->sumber, PHP_URL_HOST) }}</a></span>
                </div>
            </div>
            <div class="bookmark" {{ auth()->user() && auth()->user()->favoritReseps->contains($resep->id) ? 'bookmarked' : '' }} data-id="{{ $resep->id }}">
                {!! auth()->user() && auth()->user()->favoritReseps->contains($resep->id) ? '&#9733;' : '&#9734;' !!}
            </div>

            <script>
                // bookmark toggle tetap ada
                document.querySelectorAll('.bookmark').forEach(bookmark => {
                    bookmark.addEventListener('click', function (event) {
                        event.stopPropagation(); // agar tidak ikut toggle card
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
                            el.classList.toggle('bookmarked');
                            el.innerHTML = el.classList.contains('bookmarked') ? '&#9733;' : '&#9734;';
                        });
                    });
                });

                // Expand/collapse card saat diklik
                function toggleDetails(card) {
                    card.classList.toggle('expanded');
                }
            </script>

            <div class="recipe-details">
                <h4>Bahan-bahan:</h4>
                <ul>
                    @foreach ($resep->bahans as $bahan)
                        <li>{{ $bahan->nama_bahan }} - {{ $bahan->jumlah }}</li>
                    @endforeach
                </ul>
                <h4>Langkah-langkah:</h4>
                <!-- <p>{!! nl2br(e($resep->langkah)) !!}</p> -->
                <ol>
                    @foreach (explode("\n", $resep->langkah) as $step)
                        @if(trim($step) !== '')
                            <li>{{ $step }}</li>
                        @endif
                    @endforeach
                </ol>
            </div>

        </div>
        @endforeach
    </div>

    <script>
        // Toggle bookmark warna saat diklik
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
                    el.classList.toggle('bookmarked');
                    el.innerHTML = el.classList.contains('bookmarked') ? '&#9733;' : '&#9734;';
                });
            });
        });
    </script>
</body>
</html>