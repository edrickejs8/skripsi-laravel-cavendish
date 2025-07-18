<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanResep extends Model
{
    protected $fillable = ['resep_id', 'nama_bahan', 'jumlah']; // agar data bisa diisi langsung saat seeding/insert dari controller

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}
