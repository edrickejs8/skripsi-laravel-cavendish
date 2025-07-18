<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\PenyimpananController;
use App\Http\Controllers\RiwayatCaptureController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanResepController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeteksiKematanganController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendefinisikan semua route API untuk aplikasi kamu.
| Route ini otomatis menggunakan middleware 'api' group.
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/deteksi-kematangan', [DeteksiKematanganController::class, 'classifyBanana']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
});

// Resep Routes
Route::get('/reseps', [ResepController::class, 'index']);
Route::get('/reseps/{id}', [ResepController::class, 'show']);
Route::post('/reseps', [ResepController::class, 'store']);
Route::put('/reseps/{id}', [ResepController::class, 'update']);
Route::delete('/reseps/{id}', [ResepController::class, 'destroy']);

// Penyimpanan Routes
Route::apiResource('penyimpanan', PenyimpananController::class);
Route::get('penyimpanan/kematangan/{tingkat_kematangan}', [PenyimpananController::class, 'byTingkatKematangan']);

// Riwayat Capture Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/riwayat-captures', [RiwayatCaptureController::class, 'index']);
    Route::post('/riwayat-captures', [RiwayatCaptureController::class, 'store']);
    Route::get('/riwayat-captures/{id}', [RiwayatCaptureController::class, 'show']);
});

// Favorit Routes
Route::middleware('auth:sanctum')->post('/favorit/{resepId}', [FavoritController::class, 'toggle']);
Route::middleware('auth:sanctum')->get('/favorit', [FavoritController::class, 'listFavorit']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin-only', [AdminController::class, 'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'index']);
});

// Bahan Resep
Route::apiResource('bahan-resep', BahanResepController::class);
// apiResorce sudah otomatis bikin semua endpoint CRUD
// GET /api/bahan-resep
// POST /api/bahan-resep
// GET /api/bahan-resep/{id}
// PUT/PATCH /api/bahan-resep/{id}
// DELETE /api/bahan-resep/{id}