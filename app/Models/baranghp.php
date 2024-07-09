<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class baranghp extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function kategori_baranghp(){
        return $this->belongsto (kategoribarang::class, 'kategoribarang_id');
    }

    public function baranghp_masuk(){
        return $this->belongsto (barangmasuk::class, 'barangmasuk_id');
    }
    public function satuanbaranghp(){
        return $this->belongsto (satuan::class,'satuan_id');
    }

    public function barang_keluar(){
        return $this->hasmany (barangkeluar::class,'id');
    }
}
