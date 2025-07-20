<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevidenSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'umkm_id', 
        'jadwal_bagi', 
        'total_keuntungan', 
        'is_distributed',
        'distributed_at',
        'catatan'
    ];
    
    protected $casts = [
        'jadwal_bagi' => 'date',
        'total_keuntungan' => 'decimal:2',
        'is_distributed' => 'boolean',
        'distributed_at' => 'datetime'
    ];
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
