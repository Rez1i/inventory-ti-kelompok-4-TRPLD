<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barangkeluar extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function barang_keluar(){
        return $this->belongsto (baranghp::class, 'barangkeluar_id');
    }

    public function satuanbarangkeluar(){
        return $this->belongsto (satuan::class,'satuan_id');
    }

    public function penanggung_jawab(){
        return $this->belongsto (user::class,'user_id');
    }
}
