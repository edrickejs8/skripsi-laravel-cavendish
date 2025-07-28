<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        try {
            return view('frontend.login');
        } catch (\Exception $e) {
            dd($e->getMessage()); // akan menampilkan error jika view tidak ditemukan
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function showRegister()
    {
        try {
            return view('frontend.register');
        } catch (\Exception $e) {
            dd($e->getMessage()); // akan menampilkan error jika view tidak ditemukan
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'email.unique' => 'Akun sudah terdaftar.'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user'
            ]);

            Log::info("User berhasil dibuat: " . $user->id);

            Auth::login($user); // langsung login setelah daftar

            Log::info('User berhasil login dengan ID: ' . Auth::id());

            return redirect('/home');
        } catch (\Exception $e) {
            Log::error('Error saat register: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
