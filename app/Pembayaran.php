<?php

namespace App;

use App\Pembayaran;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

    public function hutang()
    {
        return $this->belongsTo('App\Hutang', 'id_nasabah');
    }
}
