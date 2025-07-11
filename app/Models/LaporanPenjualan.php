<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'umkm_id', 'file', 'keterangan', 'status'
    ];
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
