<?php

namespace App;

use App\JenisKandang;
use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    public function getJenisKandang()
    {
        return $this->belongsTo(JenisKandang::class, 'id_jenis_kandang', 'id');
    }
}
