<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersUjian extends Model
{
    protected $fillable = [
        'user_id', 'pelajaran_id','kelas_id', 'start_timestamp', 'end_timestamp', 'is_done'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function pelajarans()
    {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id');
    }
    public function kelas()
    {
        return $this->belongsTo(kelas::class, 'kelas_id');
    }
}
