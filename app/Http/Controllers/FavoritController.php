<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    // Tambah atau hapus resep dari favorit
    public function toggle($resepId)
    {
        $user = auth()->user(); // mendapatkan pengguna yang lagi login

        // Kalau pengguna gaditemukan, kembali respons error
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Kalau pengguna ada, lanjut dengan logic toggle favorit
        $resep = Resep::find($resepId);

        if (!$resep) {
            return response()->json(['error' => 'Resep not found'], 404);
        }

        // Melakukan toggle favorit
        if ($user->favoritReseps()->where('resep_id', $resepId)->exists()) {
            // Jika resep sudah ada di dalam favorit, hapus
            $user->favoritReseps()->detach($resepId);
            return response()->json(['message' => 'Resep dihapus dari favorit']);
        } else {
            // jika resep belum ada dalam favorit, tambahkan
            $user->favoritReseps()->attach($resepId);
            return response()->json(['message' => 'Resep ditambahkan ke favorit']);
        }
    }

    // public function listFavorit(Request $request)
    // {
    //     // Mendapatkan user yang sedang login
    //     $user = Auth::user();

    //     // Mengambil resep-resep favorit user
    //     $favoritReseps = $user->favoritReseps;

    //     // Mengembalikan daftar resep favorit dalam format JSON
    //     return response()->json($favoritReseps);
    // }

    // Tampilkan semua resep favorit
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoritReseps()->with(['user', 'bahans'])->get();

        return view('frontend.favorit', compact('favorites'));
    }
}
