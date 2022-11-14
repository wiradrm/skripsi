<?php

namespace App;

use App\Simpan;
use Illuminate\Database\Eloquent\Model;

class Simpan extends Model
{
    protected $table = 'simpan';

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }
}
