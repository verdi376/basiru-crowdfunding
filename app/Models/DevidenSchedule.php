<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevidenSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'umkm_id', 'jadwal_bagi', 'total_keuntungan', 'fee_admin', 'is_distributed'
    ];
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
