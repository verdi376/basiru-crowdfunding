<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\Umkm;
use App\Models\ProfilInvestor; // ⬅️ Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'saldo',
        'role', // 'user' atau 'admin'
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

    /**
     * Relasi ke transaksi (investor)
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    /**
     * Relasi ke UMKM (pelaku usaha)
     */
    public function umkm()
    {
        return $this->hasOne(Umkm::class);
    }

    /**
     * Relasi ke profil investor
     */
    public function profilInvestor()
    {
        return $this->hasOne(ProfilInvestor::class, 'user_id');
    }

    /**
     * Cek kelengkapan profil investor
     */
    public function isProfileComplete()
    {
        // Contoh: cek field wajib, sesuaikan dengan kebutuhan
        return $this->nama_lengkap && $this->alamat && $this->no_ktp;
    }

    /**
     * Relasi ke pembayaran deviden yang diterima investor
     */
    public function dividendPayments()
    {
        return $this->hasMany(DividendPayment::class, 'investor_id');
    }

    /**
     * Relasi ke pengembalian modal yang diterima investor
     */
    public function capitalReturns()
    {
        return $this->hasMany(CapitalReturn::class, 'investor_id');
    }
    
    /**
     * Relasi ke investasi aktif investor
     */
    public function investments()
    {
        return $this->hasMany(Investment::class, 'investor_id')
            ->where('status', 'active');
    }
}
