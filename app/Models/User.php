<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\Umkm;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'saldo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'saldo' => 'integer',
        ];
    }

    // Relasi ke transaksi (investor)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    // Relasi ke UMKM (pelaku usaha)
    public function umkm()
    {
        return $this->hasOne(Umkm::class, 'user_id');
    }
}
