<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE reseps MODIFY tingkat_kematangan ENUM('Mentah', 'Sedikit Matang', 'Matang', 'Matang Sekali', 'Busuk') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE reseps MODIFY tingkat_kematangan ENUM('mentah', 'sedikit matang', 'matang', 'matang sekali', 'busuk') NOT NULL");
    }
};
