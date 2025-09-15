<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriDiklat extends Model
{
    use HasFactory;

    protected $table = 'materi_diklat';

    protected $fillable = [
        'nama',
        'foto',
        'dokumen',
    ];

}
