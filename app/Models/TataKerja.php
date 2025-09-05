<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TataKerja extends Model
{
    use HasFactory;

    protected $table = 'tata_kerja';

    protected $fillable = [
        'nama',
        'foto',
        'dokumen',
    ];
}
