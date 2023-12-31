<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    
    protected $fillable = ['user_id', 'pelajaran', 'kode_akses', 'durasi', 'waktu_menit'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
    
}
