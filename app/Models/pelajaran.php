<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    protected $fillable = ['pelajaran', 'kode_akses'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'guru_mengajars', 'pelajaran_id', 'user_id');
    }

    public function guruMengajars()
    {
        return $this->hasMany(GuruMengajar::class, 'pelajaran_id');
    }
}
