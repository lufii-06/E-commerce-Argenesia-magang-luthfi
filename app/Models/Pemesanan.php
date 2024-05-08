<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'toko_id',
        'name',
        'nohp',
        'alamat',
        'tanggal',
        'total',
        'status',
        'jenispembayaran',
        'buktipembayaran'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function toko(){
        return $this->belongsTo(Toko::class,'toko_id');
    }

    public function DetailPemesanan(){
        return $this->hasMany(DetailPemesanan::class,'pemesanan_id');
    }
}
