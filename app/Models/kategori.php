<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';
    
    protected $guarded = [
        'id'
    ];

    public function kategoriberita(){
        return $this->hasmany (berita::class,'id');
    }
    
}
