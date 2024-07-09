<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisbarang extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function kategori_barang(){
        return $this->belongsto (kategoribarang::class, 'kategoribarang_id');
    }

    public function jenis_barang(){
        return $this->hasmany (barang::class,'id');
    }
}

