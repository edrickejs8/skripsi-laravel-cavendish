<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RiwayatCapture;
use App\Models\User;
use App\Models\Penyimpanan;

class RiwayatCaptureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $penyimpanan = Penyimpanan::where('tingkat_kematangan', 'matang')->first();

        RiwayatCapture::create([
            'user_id' => $user->id,
            'gambar' => 'capture1.jpg',
            'tingkat_kematangan' => 'matang',
            'penyimpanan_id' => $penyimpanan->id,
        ]);
    }
}
