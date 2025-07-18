<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Resep extends Model
{
    protected $fillable = ['nama_resep','deskripsi', 'tingkat_kematangan', 'langkah', 'gambar']; // untuk pengisian data otomatis

    public function bahans()
    {
        return $this->hasMany(BahanResep::class);
    }

    public function favoritOleh()
    {
        return $this->belongsToMany(User::class, 'favorit_reseps')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
