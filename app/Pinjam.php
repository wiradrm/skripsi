<?php

namespace App;

use App\Pinjam;
use App\Nasabah;
use App\Hutang;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $table = 'pinjam';

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

    public function hutangs()
    {
        return $this->belongsTo('App\Hutang', 'no_pinjam');
    }

}
