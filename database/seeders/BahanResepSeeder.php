<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BahanResep;
use App\Models\Resep;

class BahanResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resep1 = Resep::where('nama_resep', 'Pisang Goreng Crispy')->first();
        $resep2 = Resep::where('nama_resep', 'Banana Smoothie')->first();

        if (!$resep1 || !$resep2) {
            $this->command->error('Resep belum tersedia. Jalankan ResepSeeder terlebih dahulu.');
        }

        BahanResep::insert([
            ['resep_id' => $resep1->id, 'nama_bahan' => 'Pisang', 'jumlah' => '2 buah'],
            ['resep_id' => $resep1->id, 'nama_bahan' => 'Tepung', 'jumlah' => '100 gram'],
            ['resep_id' => $resep2->id, 'nama_bahan' => 'Pisang', 'jumlah' => '1 buah'],
            ['resep_id' => $resep2->id, 'nama_bahan' => 'Susu', 'jumlah' => '200 ml'],
        ]);
    }
}
