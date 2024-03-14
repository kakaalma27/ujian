<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class format_ujian extends Model
{
    protected $table = 'format_ujian';

    protected $fillable = [
        'name',
        'path',
    ];
}
