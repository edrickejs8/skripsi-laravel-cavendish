<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyimpanan extends Model
{
    protected $fillable = ['tingkat_kematangan', 'deskripsi']; // Untuk pengisian otomatis kalau pake seeder

    public function captures()
    {
        return $this->hasMany(RiwayatCapture::class);
    }
}
