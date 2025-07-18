<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyimpanan;

class PenyimpananController extends Controller
{
    // menampilkan semua data penyimpanan
    public function index()
    {
        $penyimpanan = Penyimpanan::all();
        return response()->json($penyimpanan);
    }

    // menampilkan penyimpanan berdasarkan tingkat kematangan
    public function byTingkatKematangan($tingkat_kematangan)
    {
        $data = Penyimpanan::where('tingkat_kematangan', $tingkat_kematangan)->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    // detail penyimpanan by id
    public function show($id)
    {
        $penyimpanan = Penyimpanan::find($id);

        if (!$penyimpanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($penyimpanan);
    }

    // tambah data penyimpanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat_kematangan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $penyimpanan = Penyimpanan::create($validated);

        return response()->json($penyimpanan, 201);
    }

    // Update data penyimpanan
    public function update(Request $request, $id)
    {
        $penyimpanan = Penyimpanan::find($id);

        if (!$penyimpanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'tingkat_kematangan' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
        ]);

        $penyimpanan->update($validated);

        return response()->json($penyimpanan);
    }

    // Hapus data penyimpanan
    public function destroy($id)
    {
        $penyimpanan = Penyimpanan::find($id);

        if (!$penyimpanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $penyimpanan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
