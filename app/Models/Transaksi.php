<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis',
        'jumlah',
        'status',
        'bukti',
        'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
