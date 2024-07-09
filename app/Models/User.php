<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userberita(){
        return $this->hasmany (berita::class,'id');
    }
    public function userkomentar(){
        return $this->hasmany (komentar::class,'id');
    }
    public function penanggungjawabbrgmsk(){
        return $this->hasmany (barangmasuk::class,'id');
    }

    public function penanggung_jawab(){
        return $this->hasmany (barangkeluar::class,'id');
    }

    public function penanggung_jawab_pemindahan(){
        return $this->hasmany (pemindahaninventaris::class,'id');
    }

    public function penanggung_jawab_peminjaman(){
        return $this->hasmany (transaksi::class,'id');
    }

    public function userpeminjam(){
        return $this->hasmany (pengajuanpeminjaman::class,'id');
    }

    public function useraktivitas(){
        return $this->hasmany (logaktivitas::class,'id');
    }
}
