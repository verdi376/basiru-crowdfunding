<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'alamat',
        'telepon',
        'kategori',
        'lokasi',
        'kontak',
        'foto',
        'dana_dibutuhkan', // ← dibutuhkan untuk target donasi
    ];

    /**
     * Relasi ke user pemilik UMKM
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke semua transaksi yang berkaitan dengan UMKM ini
     */
    public function transaksis()
    {
        return $this->hasMany(\App\Models\Transaksi::class);
    }

    /**
     * Akses total dana yang sudah terkumpul (donasi diterima)
     */
    public function getDanaTerkumpulAttribute()
    {
        return $this->transaksis()
            ->where('jenis', 'donasi')
            ->where('status', 'diterima')
            ->sum('jumlah');
    }

    /**
     * (Opsional) Cek apakah target dana sudah tercapai
     */
    public function getIsDanaTercapaiAttribute()
    {
        return $this->dana_terkumpul >= $this->dana_dibutuhkan;
    }

    /**
     * Relasi ke semua investor yang berinvestasi di UMKM ini
     */
    public function investors()
    {
        return $this->belongsToMany(User::class, 'transaksis', 'umkm_id', 'user_id')
            ->where('jenis', 'investasi')
            ->where('status', 'selesai')
            ->distinct();
    }

    /**
     * Relasi ke semua laporan penjualan yang berkaitan dengan UMKM ini
     */
    public function laporanPenjualan()
    {
        return $this->hasMany(\App\Models\LaporanPenjualan::class);
    }

    /**
     * Relasi ke semua jadwal deviden yang berkaitan dengan UMKM ini
     */
    public function devidenSchedules()
    {
        return $this->hasMany(\App\Models\DevidenSchedule::class);
    }
}
