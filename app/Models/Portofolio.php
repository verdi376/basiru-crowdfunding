<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Portofolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telepon',
        'alamat',
        'pekerjaan',
        'penghasilan',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
