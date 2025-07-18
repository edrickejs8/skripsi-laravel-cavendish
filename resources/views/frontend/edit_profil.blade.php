<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Cavendish!</title>
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
        <h2>Edit Profil</h2>

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group">
                <label for="photo">Foto Profil (opsional)</label>
                <input type="file" id="photo" name="photo">
                @if ($user->photo_path)
                    <div style="margin-top: 10px;">
                        <img src="{{ asset($user->photo_path) }}" alt="Foto Sekarang" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                    </div>
                @endif
            </div>

            <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </form>
    </main>
</body>
</html>