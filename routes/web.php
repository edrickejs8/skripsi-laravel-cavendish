<?php

use App\Http\Controllers\FavoritController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RiwayatCaptureController;
use App\Http\Controllers\PenyimpananWebController;

// Landing Page
Route::get('/', function () {
    return view('frontend.index');
});

// Custom auth route
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Home route (protected)
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/hasil-scan', [HomeController::class, 'hasilScan'])->middleware('auth')->name('hasil.scan');

// Penyimpanan route
Route::get('/penyimpanan/{tingkatKematangan}', [PenyimpananWebController::class, 'show']);

// Resep route
Route::get('/resep', [ResepController::class, 'index'])->name('resep');
Route::get('/resep/{id}', [ResepController::class, 'show'])->name('resep.show');

// Profil route
Route::get('/profil', function () {
    return view('frontend.profil');
})->name('profil')->middleware('auth');

// Profil Edit Route
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profil.edit')->middleware('auth');
Route::post('/profil/update', [UserController::class, 'update'])->name('profil.update')->middleware('auth');

// Riwayat route
Route::get('/riwayat', [RiwayatCaptureController::class, 'riwayatPage'])->middleware('auth')->name('riwayat');
Route::post('/riwayat-captures', [RiwayatCaptureController::class, 'store'])->middleware('auth')->name('riwayat.capture.store');

// Tambah/hapus favorit (POST)
Route::post('/favorit/toggle/{id}', [FavoritController::class, 'toggle'])->middleware('auth')->name('favorit.toggle');

// Menampilkan halaman favorit
Route::get('/favorit', [FavoritController::class, 'index'])->middleware('auth')->name('favorit');

// require __DIR__.'/auth.php';
