<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisKandang extends Model
{
    public function getJumlahAyam()
    {
        return $this->belongsTo(Ayam::class, 'id', 'id_jenis_kandang');
    }
}
