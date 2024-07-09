<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class berita extends Model
{
    use HasFactory;
    protected $table = 'beritas';
    protected $guarded = [
        'id'
    ];

    public function userberita(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function komentarberita(){
        return $this->hasMany(Komentar::class, 'id');
    }

    public function kategoriberita(){
        return $this->belongsTo(kategori::class, 'kategori_id');
    }
}

