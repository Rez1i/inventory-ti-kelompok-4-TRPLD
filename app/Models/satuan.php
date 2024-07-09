<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function satuanbarang(){
        return $this->hasmany (barang::class,'id');
    }
    public function satuanbaranghp(){
        return $this->hasmany (baranghp::class,'id');
    }
    public function satuandbmasuk(){
        return $this->hasmany (dbmasuk::class,'id');
    }
    public function satuanbarangkeluar(){
        return $this->hasmany (barangkeluar::class,'id');
    }
}
