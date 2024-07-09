<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'staffs';

    public function bagianstaff(){
        return $this->belongsto (bagian::class, 'bagian_id');
    }

}
