<?php

namespace App;

use App\RiwayatTabungan;
use Illuminate\Database\Eloquent\Model;

class RiwayatTabungan extends Model
{
    protected $table = 'riwayat_tabungan';

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }
}
