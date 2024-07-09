<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komentar extends Model
{
    use HasFactory;
    protected $table = 'komentars';
    protected $guarded = [
        'id'
    ];

    public function userkomentar(){
        return $this->belongsto (user::class, 'user_id');
    }
    public function komentarberita(){
        return $this->belongsto (berita::class, 'berita_id');
    }
}
