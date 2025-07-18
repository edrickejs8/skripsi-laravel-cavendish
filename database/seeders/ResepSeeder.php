<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resep;
use App\Models\User;

class ResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Mengambil user pertama sebagai pemilik resep

        Resep::create([
            'user_id' => $user->id,
            'nama_resep' => 'Pisang Goreng Crispy',
            'deskripsi' => 'Pisang digoreng dengan tepung renyah',
            'tingkat_kematangan' => 'matang',
            'langkah' => '1. Kupas pisang, 2. Celupkan ke adonan, 3. Goreng hingga keemasan',
            'gambar' => 'pisang_goreng.jpg',
            'sumber' => 'https://cookpad.com/id/resep/123456-pisang-goreng-crispy'
        ]);

        Resep::create([
            'user_id' => $user->id,
            'nama_resep' => 'Banana Smoothie',
            'deskripsi' => 'Smoothie segar dari pisang dan susu',
            'tingkat_kematangan' => 'matang sekali',
            'langkah' => '1. Potong pisang, 2. Campur dengan susu dan blender',
            'gambar' => 'smoothie.jpg',
            'sumber' => 'https://cookpad.com/id/resep/654321-banana-smoothie'
        ]);

        Resep::create([
            'user_id' => $user->id,
            'nama_resep' => 'Bolu Pisang Panggang',
            'deskripsi' => 'Tanpa mixer, satu telur',
            'tingkat_kematangan' => 'matang sekali',
            'langkah' => '1. Kocok pisang, telur, gula, vanili, hingga tercampur rata. Lalu tambahkan tepung terigu dan susu bubuk. Aduk rata sampai benar-benar tercampur., 2. Tambahkan baking powder, garam dan soda kue. Lalu tuangkan minyak goreng. Aduk rata lagi., 3. Tuangkan ke dalam loyang. Beri keju parut secukupnya. Panggang sampai matang di api kecil selama 40 menit., 4. Setelah matang, keluarkan dari loyang. Siap untuk disajikan.',
            'gambar' => 'bolupisang.jpg',
            'sumber' => 'https://cookpad.com/id/resep/24728437-bolu-pisang-panggang-tanpa-mixer-satu-telur?ref=search&search_term=pisang+terlalu+matang'
        ]);
    }
}
