<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barangmasuk extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function penanggungjawabbgrmsk(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailbm(){
        return $this->hasmany (dbmasuks::class,'id');
    }
}
