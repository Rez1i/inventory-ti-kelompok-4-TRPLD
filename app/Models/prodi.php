<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodi extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function ketuaprodi(){
        return $this->belongsto (dosen::class,'ketuaprodi_id');
    }
}
