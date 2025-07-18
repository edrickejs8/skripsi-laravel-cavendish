<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyimpanan;

class PenyimpananWebController extends Controller
{
    public function show($tingkatKematangan)
    {

        $mapping = [
            'unripe' => 'Mentah',
            'ripe' => 'Matang',
            'overripe' => 'Matang Sekali',
            'rotten' => 'Busuk',
        ];

        $translate = $mapping[strtolower($tingkatKematangan)] ?? $tingkatKematangan;

        $penyimpanan = Penyimpanan::where('tingkat_kematangan', $translate)->first();

        if (!$penyimpanan) {
            abort(404, 'Data penyimpanan tidak ditemukan.');
        }

        return view('frontend.penyimpanan', compact('penyimpanan'));
    }
}
