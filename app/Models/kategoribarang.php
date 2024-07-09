<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoribarang extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function kategori_barang(){
        return $this->hasmany (jenisbarang::class,'id');
    }

    public function kategori_baranghp(){
        return $this->hasmany (baranghp::class,'id');
    }
}
