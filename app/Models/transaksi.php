<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function barang_peminjaman(){
        return $this->belongsto (barang::class, 'barang_id');
    }

    public function penanggung_jawab_peminjaman(){
        return $this->belongsto (user::class,'user_id');
    }
}
