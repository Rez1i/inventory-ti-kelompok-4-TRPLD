<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penempatan extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function barang_penempatan(){
        return $this->belongsto (barang::class, 'barang_id');
    }

    public function ruangan_penempatan(){
        return $this->belongsto (ruangan::class, 'ruangan_id');
    }
}
