<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function ruangan_penempatan(){
        return $this->hasmany (penempatan::class,'id');
    }

    public function ruanganasal_pemindahan(){
        return $this->hasmany (pemindahaninventaris::class,'id');
    }
    public function ruangantujuan_pemindahan(){
        return $this->hasmany (pemindahaninventaris::class,'id');
    }

    public function ruangan_riwayatpindahtempat(){
        return $this->hasmany (penempatan::class,'id');
    }
}
