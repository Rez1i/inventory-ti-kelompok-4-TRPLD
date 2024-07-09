<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $guarded = [
        'id'
    ];

    public function prodi(){
        return $this->belongsto (prodi::class, 'prodi_id');
    }
}
