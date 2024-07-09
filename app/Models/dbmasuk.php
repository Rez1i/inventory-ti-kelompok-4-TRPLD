<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dbmasuk extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function detailbm(){
        return $this->belongsTo(barangmasuk::class, 'barangmasuk_id');
    }
    public function satuandbmasuk(){
        return $this->belongsTo (satuan::class,'satuan_id');
    }
}
