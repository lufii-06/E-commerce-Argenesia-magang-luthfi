<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'kategori',
        'name',        
        'deskripsi',        
        'stok',        
        'harga',        
        'photo',        
        'photo1',        
        'photo2',        
    ];

    public function Toko(){
        return $this->belongsTo(Toko::class,'toko_id');
    }

    public function keranjang(){
        return $this->hasMany(keranjang::class);
    }

    public function DetailPemesanan(){
        return $this->hasMany(DetailPemesanan::class,'produk_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('toko' , function($query) use ($search){
                        $query->where('name','LIKE', '%' . $search . '%')
                        ->orWhere('deskripsi','like', '%' . $search . '%');
                    });
                    
            });
        });
    }
}
