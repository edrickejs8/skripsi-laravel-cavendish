<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatCapture extends Model
{
    protected $table = 'riwayat_captures';
    
    protected $fillable = ['user_id', 'gambar', 'tingkat_kematangan', 'penyimpanan_id']; // pengisian data otomatis

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penyimpanan()
    {
        return $this->belongsTo(Penyimpanan::class);
    }
}
