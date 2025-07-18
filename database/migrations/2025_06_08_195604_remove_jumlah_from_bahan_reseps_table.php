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
        Schema::table('bahan_reseps', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahan_reseps', function (Blueprint $table) {
            $table->string('jumlah')->nullable(); // bisa di rollback
        });
    }
};
