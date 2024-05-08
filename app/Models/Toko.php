<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'deskripsi',
        'nik',
        'jenisrekening',
        'norek',
        'gambarktp',
        'gambarpendukung',
        'status'
    ];

    public function Produk(){
        return $this->hasMany(Produk::class);
    }

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function Vtoko(){
        return $this->belongsTo(Vtoko::class,'toko_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhereHas('user' , function($query) use ($search){
                        $query->where('name','LIKE', '%' . $search . '%')
                        ->orWhere('email','like', '%' . $search . '%');
                    });
                    
            });
        });

        $query->when($filters['search1'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhereHas('user' , function($query) use ($search){
                        $query->where('name','LIKE', '%' . $search . '%')
                        ->orWhere('email','like', '%' . $search . '%');
                    });
                    
            });
        });
    }
}
