<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
    ];


    public function user()
    {
        return $this->belongsToMany(User::class, 'users_kelas', 'kelas_id', 'user_id');
    }

    public function userKelas()
    {
        return $this->hasMany(usersKelas::class, 'kelas_id');
    }
}
