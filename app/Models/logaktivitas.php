<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logaktivitas extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'logaktivitas';
    protected $guarded = [
        'id'
    ];

    public function useraktivitas(){
        return $this->belongsto (user::class,'user_id');
    }
}
