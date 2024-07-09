<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function jenis_barang(){
        return $this->belongsto (jenisbarang::class, 'jenisbarang_id');
    }
    public function barang_peminjaman(){
        return $this->hasmany (transaksi::class, 'id');
    }
    public function satuanbarang(){
        return $this->belongsto (satuan::class,'satuan_id');
    }
    public function ruangan_penempatan(){
        return $this->hasmany (penempatan::class,'id');
    }
    public function pengajuanbarang(){
        return $this->hasmany (pengajuanpeminjaman::class,'id');
    }
}
