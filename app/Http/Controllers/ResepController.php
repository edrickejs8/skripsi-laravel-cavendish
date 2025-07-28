<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    // menampilkan semua resep
    public function index(Request $request)
    {
        $query = Resep::with(['bahans', 'user', 'favoritOleh'])->latest();

        // Filter pencarian (search)
        if ($request->has("q") && $request->q != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_resep', 'like', '%' . $request->q . '%')->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        // Filter tingkat kematangan
        $filter = $request->query('filter') ?? $request->query('tingkat_kematangan');
        if ($filter && \App\Enums\TingkatKematanganEnum::tryFrom($filter)) {
            $query->where('tingkat_kematangan', $filter);
        }

        $reseps = $query->get();

        return view('frontend.resep', compact('reseps', 'filter'));
    }

    // // menampilkan resep berdasarkan tingkat kematangan
    // public function byTingkatKematangan($tingkat)
    // {
    //     $reseps = Resep::where('tingkat_kematangan', $tingkat)->with('bahans')->get();
    //     return response()->json($reseps);
    // }

    // menampilkan detail resep
    public function show($id)
    {
        $resep = Resep::with('bahans', 'user')->findOrFail($id);
        return view('frontend.resep-show', compact('resep'));
    }

    // public function store(Request $request)
    // {
    //     $validate = $request->validate([
    //         'nama_resep' => 'required|string',
    //         'deskripsi' => 'required|string',
    //         'tingkat_kematangan' => 'required|string',
    //         'gambar' => 'nullable|string',
    //         'langkah' => 'required|string',
    //     ]);

    //     // simpan ke database
    //     $resep = Resep::create($validate);

    //     // Redirect atau response
    //     return response()->json([
    //         'message' => 'Resep berhasil ditambahkan',
    //         'data' => $resep
    //     ], 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $validate = $request->validate([
    //         'nama_resep' => 'required|string',
    //         'deskripsi' => 'required|string',
    //         'tingkat_kematangan' => 'required|string',
    //         'gambar' => 'nullable|string',
    //         'langkah' => 'required|string',
    //     ]);

    //     $resep = Resep::findOrFail($id);
    //     $resep->update($validate);

    //     return response()->json([
    //         'message' => 'Resep berhasil diperbarui',
    //         'data' => $resep
    //     ]);
    // }

    // //Menghapus resep
    // public function destroy($id)
    // {
    //     $resep = Resep::findOrFail($id);
    //     $resep->delete();

    //     return response()->json([
    //         'message' => 'Resep berhasil dihapus'
    //     ]);
    // }
}
