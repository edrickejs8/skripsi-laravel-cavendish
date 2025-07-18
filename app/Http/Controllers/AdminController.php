<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        return response()->json(['message' => 'Ini halaman dashboard Admin']);
    }

    // Menampilkan semua user (hanya untuk admin)
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Daftar semua user',
            'data' => $users
        ]);
    }
}
