<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodePembayaran extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kode',
        'tipe',
        'nomor_rekening',
        'atas_nama',
        'logo',
        'keterangan',
        'status',
        'urutan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'kode';
    }

    /**
     * Scope a query to only include active payment methods.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get the human-readable type name.
     */
    public function getTipeTextAttribute(): string
    {
        return match($this->tipe) {
            'bank' => 'Bank Transfer',
            'ewallet' => 'E-Wallet',
            'qris' => 'QRIS',
            default => ucfirst($this->tipe),
        };
    }
}
