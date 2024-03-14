<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban extends Model
{
    protected $fillable = ['soal_id', 'isi_jawaban', 'is_correct'];

    public function soals()
    {
        return $this->belongsTo(soal::class, 'soal_id', 'id');
    }
    
}
