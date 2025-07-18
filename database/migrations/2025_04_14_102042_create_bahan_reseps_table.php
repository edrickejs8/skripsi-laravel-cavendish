<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bahan_reseps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained()->onDelete('cascade');
            $table->string('nama_bahan');
            $table->string('jumlah'); // contoh: "2 buah", "100 gram", dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_reseps');
    }
};
