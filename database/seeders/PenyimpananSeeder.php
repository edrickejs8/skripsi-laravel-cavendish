<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penyimpanan;

class PenyimpananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penyimpanan::insert([
            ['tingkat_kematangan' => 'mentah', 'deskripsi' => 'Simpan di suhu ruangan hingga matang'],
            ['tingkat_kematangan' => 'matang', 'deskripsi' => 'Simpan di kulkas, tahan 2-3 hari'],
            ['tingkat_kematangan' => 'matang sekali', 'deskripsi' => 'Simpan di freezer untuk olahan smoothie atau kue'],
            ['tingkat_kematangan' => 'busuk', 'deskripsi' => 'Segera buang, tidak disarankan untuk dikonsumsi'],
        ]);
    }
}
