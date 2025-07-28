<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Penyimpanan;
use App\Models\RiwayatCapture;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }

    public function hasilScan()
    {
        $riwayat = RiwayatCapture::latest()->first(); // Mengambil capture terakhir

        if (!$riwayat) {
            return view('frontend.home', ['reseps' => collect(), 'penyimpanan' => null]);
        }

        $reseps = Resep::with('bahans')->where('tingkat_kematangan', $riwayat->tingkat_kematangan)->get();
        $penyimpanan = Penyimpanan::find($riwayat->penyimpanan_id);

        return view('frontend.home', compact('reseps', 'penyimpanan'));
    }
}
