<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPenjualan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laporan_penjualan';
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'umkm_id',
        'judul',
        'file',
        'keterangan',
        'status',
        'catatan_admin',
        'total_penjualan',
        'total_keuntungan',
        'periode_awal',
        'periode_akhir',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'periode_awal' => 'date:Y-m-d',
        'periode_akhir' => 'date:Y-m-d',
        'total_penjualan' => 'decimal:2',
        'total_keuntungan' => 'decimal:2',
    ];

    /**
     * Get the UMKM that owns the laporan penjualan.
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }
}
