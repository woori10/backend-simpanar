<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{
    protected $table = 'video_tutorial';
    protected $fillable = [
        'daftar_alat_id',
        'file_video'
    ];

    public function daftarAlat()
    {
        return $this->belongsTo(DaftarAlat::class);
    }
}
