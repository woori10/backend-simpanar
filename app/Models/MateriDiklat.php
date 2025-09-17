<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriDiklat extends Model
{
    use HasFactory;

    protected $table = 'materi_diklat';

    protected $fillable = [
        'daftar_alat_id',
        'nama_alat',
        'foto',
        'file_pdf'
    ];

    public function daftarAlat() {
        // return $this->belongsTo(DaftarAlat::class, 'daftar_alat_id');
        return $this->belongsTo(DaftarAlat::class);
    }
}
