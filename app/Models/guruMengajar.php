<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guruMengajar extends Model
{
    protected $fillable = [
        'user_id',
        'pelajaran_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelajarans()
    {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id');
    }
}
