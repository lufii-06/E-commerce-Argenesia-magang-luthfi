<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'produk_id',
        'qty',
        'subtotal',
    ];

    public function Pemesanan(){
        return $this->belongsTo(Pemesanan::class,'pemesanan_id');
    }

    public function Produk(){
        return $this->belongsTo(Produk::class,'produk_id');
    }
}
