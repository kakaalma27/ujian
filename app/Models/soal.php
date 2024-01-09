<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soal extends Model
{
    protected $table = "soals";

    protected $fillable = [
        'user_id',
        'kelas_id',
        'pelajaran_id',
        'isi_soal',
    ];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(usersKelas::class, 'kelas_id','id');
    }

    public function pelajarans()
    {
        return $this->belongsTo(pelajaran::class, 'pelajaran_id','id');
    }
    public function jawabans()
    {
        return $this->hasMany(Jawaban::class, 'soal_id', 'id');
    }
}
