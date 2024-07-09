<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuanpeminjaman extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'pengajuanpeminjamans';

    public function pengajuanbarang(){
        return $this->belongsto (barang::class,'barang_id');
    }

    public function userpeminjam(){
        return $this->belongsto (user::class,'user_id');
    }
}
