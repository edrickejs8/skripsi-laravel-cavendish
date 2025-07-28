<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatCapture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TingkatKematanganEnum;

class RiwayatCaptureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|string', // base64 dari kamera
        ]);

        $user = Auth::user();

        // Simpan gambar base64 ke file
        $base64Image = $request->gambar;
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $filename = uniqid() . '.jpg';
        $relativePath = 'uploads/' . $filename;
        $path = storage_path('app/public/' . $relativePath);
        file_put_contents($path, $imageData);

        // Kirim ke AI
        $hasilAI = $this->kirimAI($path);
        
        // Mapping hasil prediksi AI dari English ke format enum database
        $mapping = [
            'unripe' => 'Mentah',
            'ripe' => 'Matang',
            'overripe' => 'Matang Sekali',
            'rotten' => 'Busuk',
        ];

        $rawPrediction = strtolower(trim($hasilAI['prediction'] ?? ''));
        $tingkatKematangan = $mapping[$rawPrediction] ?? null;

        // Validasi hasil akhir prediksi
        if (!in_array($tingkatKematangan, array_column(TingkatKematanganEnum::cases(), 'value'))) {
            return response()->json(['error' => 'Prediksi tidak valid dari AI.'], 422);
        }

        // Cari penyimpanan berdasarkan enum yang sudah selesai
        $penyimpanan = \App\Models\Penyimpanan::where('tingkat_kematangan', $tingkatKematangan)->first();

        if (!$penyimpanan) {
            return response()->json(['error' => 'Data penyimpanan tidak ditemukan untuk tingkat kematangan ini.'], 404);
        }

        // Simpan ke DB
        $riwayat = RiwayatCapture::create([
            'user_id' => $user->id,
            'gambar' => $relativePath,
            'tingkat_kematangan' => $tingkatKematangan,
            'penyimpanan_id' => $penyimpanan->id
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'tingkat_kematangan' => $tingkatKematangan,
                'penyimpanan_id' => $penyimpanan->id,
                'gambar' => $riwayat->gambar,
            ]
        ]);
    }

    // public function index()
    // {
    //     $riwayats = RiwayatCapture::with('penyimpanan')
    //         ->where('user_id', Auth::id())
    //         ->latest()
    //         ->get();
        
    //     return response()->json($riwayats);
    // }

    // public function show($id)
    // {
    //     $riwayat = RiwayatCapture::with('penyimpanan')
    //         ->where('user_id', Auth::id())
    //         ->findOrFail($id);
        
    //     return response()->json($riwayat);
    // }

    public function riwayatPage()
    {
        $riwayats = RiwayatCapture::with('penyimpanan')->where('user_id', Auth::id())->latest()->get();

        return view('frontend.riwayat', compact('riwayats'));
    }

    private function kirimAI($pathGambar)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/predict');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $cfile = new \CURLFile($pathGambar, 'image/jpeg', 'image.jpg');
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => $cfile]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
