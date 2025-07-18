<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Resep;
use App\Models\RiwayatCapture;

/**
 * App\Model\User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Resep[] $favoritReseps
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\RiwayatCapture[] $riwayatCaptures
 *
 * @mixin \Eloquent
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi many-to-many ke tabel 'favorit_reseps'
     * 
     * @return BelongsToMany
     */
    public function favoritReseps()
    {
        return $this->belongsToMany(Resep::class, 'favorit_reseps', 'user_id', 'resep_id')->withTimestamps();
    }

    /**
     * Relasi one-to-many ke tabel 'riwayat_captures'
     * 
     * @return HasMany
     */
    public function riwayatCaptures()
    {
        return $this->hasMany(RiwayatCapture::class);
    }

    /**
     * Relasi one-to-many ke tabel 'reseps'
     * 
     * @return HasMany
     */
    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}
