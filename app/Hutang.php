<?php

namespace App;

use App\Hutang;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';

    public function hutangs()
    {
        return $this->hasMany('App\Hutang', 'id_nasabah');
    }

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

    public function pinjam()
    {
        return $this->belongsTo('App\Pinjam', 'id_nasabah');
    }
}
