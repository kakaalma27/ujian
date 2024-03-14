<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class users_jawaban extends Model
{
    protected $table = "users_jawabans";

    protected $fillable = [
        'user_id',
        'soal_id',
        'jawaban_id',
        'kode_akses',
        'result',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function soals()
    {
        return $this->belongsTo(soal::class, 'soal_id', 'id');
    }

    public function jawabans()
    {
        return $this->belongsTo(jawaban::class, 'jawaban_id', 'id');
    }
    public function pelajarans()
    {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(usersKelas::class, 'kelas_id', 'id');
    }
}
