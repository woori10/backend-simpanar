<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarAlat extends Model
{
    protected $table = 'daftar_alat';
    protected $fillable = ['nama_alat','foto'];

    public function materiDiklat()
    {
        return $this->hasMany(MateriDiklat::class);
    }

    public function videoTutorial()
    {
        return $this->hasMany(VideoTutorial::class);
    }
}
