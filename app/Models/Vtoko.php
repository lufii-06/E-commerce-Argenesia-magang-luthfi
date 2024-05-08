<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vtoko extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'pesan'
    ];
}
