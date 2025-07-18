<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BahanResep;

class BahanResepController extends Controller
{
    // List semua bahan resep
    public function index()
    {
        $bahanResep = BahanResep::all();
        return response()->json($bahanResep);
    }

    // Tambah bahan resep baru
    public function store(Request $request)
    {
        $validate = $request->validate([
            'resep_id' => 'required|exists:reseps,id',
            'nama_bahan' => 'required|string|max:255',
            // 'jumlah' => 'required|string|max:255',
        ]);

        $bahanResep = BahanResep::create($validate);

        return response()->json($bahanResep, 201);
    }

    // Lihat satu bahan resep
    public function show($id)
    {
        $bahanResep = BahanResep::findOrFail($id);
        return response()->json($bahanResep);
    }

    // Update bahan resep
    public function update(Request $request, $id)
    {
        $bahanResep = BahanResep::findOrFail($id);

        $validate = $request->validate([
            'resep_id' => 'sometimes|exists:reseps,id',
            'nama_bahan' => 'sometimes|string|max:255',
            // 'jumlah' => 'sometimes|string|max:255',
        ]);

        $bahanResep->update($validate);

        return response()->json($bahanResep);
    }

    //Hapus bahan resep
    public function destroy($id)
    {
        $bahanResep = BahanResep::findOrFail($id);
        $bahanResep->delete();

        return response()->json(['message' => 'Bahan resep deleted successfully']);
    }
}
