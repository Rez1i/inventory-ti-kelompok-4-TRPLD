<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemindahaninventaris extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function barang_pemindahan(){
        return $this->belongsto (barang::class, 'barang_id');
    }

    public function penanggung_jawab_pemindahan(){
        return $this->belongsto (user::class,'penanggungjawab_id');
    }

    public function ruanganasal_pemindahan(){
        return $this->belongsto (ruangan::class, 'ruanganasal_id');
    }

    public function ruangantujuan_pemindahan(){
        return $this->belongsto (ruangan::class, 'ruangantujuan_id');
    }
}
