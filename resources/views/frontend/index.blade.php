<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cavendish!</title>
    <link rel="stylesheet" href="{{ asset('frontend/index.css') }}">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <img src="{{ asset('frontend/pisang-removebg-preview.png') }}" alt="Logo">
            </div>
            <button class="btn1" id="btnLogin" data-url="{{ route('login') }}">Masuk</button>
            <button class="btn2" id="btnRegister" data-url="{{ route('register') }}">Daftar</button>
        </div>
    </div>

    <script>
        document.getElementById('btnLogin').addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });

        document.getElementById('btnRegister').addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    </script>
</body>
</html>