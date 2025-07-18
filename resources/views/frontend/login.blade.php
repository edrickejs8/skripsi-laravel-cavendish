<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cavendish!</title>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('frontend/index.css') }}">
</head>
<body>
    <div class="container">
        <div>
            <h2>Login</h2>
            @if (session('error'))
                <p style="color:red;">{{ session('error') }}</p>
            @endif
            <div class="form-box login">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom: 10px;">
                    <input type="email" name="email" placeholder="Email" required style="padding: 10px; width: 300px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <input type="password" name="password" placeholder="Password" required style="padding: 10px; width: 300px;">
                </div>
                <button type="submit" class="btn1">Login</button>
                </form>


                    <!-- <h1>Login</h1>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required>
                        <i class='bxr  bx-user'  ></i> 
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required>
                        <i class='bxr  bx-lock'  ></i> 
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>

            <div class="form-box register">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                    <h1>Registration</h1>
                    <div class="input-box">
                        <input type="text" placeholder="Username" required>
                        <i class='bxr  bx-user'  ></i> 
                    </div>
                     <div class="input-box">
                        <input type="email" placeholder="Email" required>
                        <i class='bxr  bx-user'  ></i> 
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required>
                        <i class='bxr  bx-lock'  ></i> 
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div> -->

            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>