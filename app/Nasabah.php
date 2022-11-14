<?php

namespace App;

use App\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Nasabah extends Model
{
    protected $table = 'nasabah';

    public function checkLastRecord(){
        $latest = Nasabah::latest('id')->pluck('id')->first();
        return $latest;
    }

    public function tabungan()
    {
        return $this->hasOne('App\Tabungan', 'id_nasabah');
    }

    public function simpan()
    {
        return $this->hasMany('App\Simpan', 'id_nasabah');
    }

    public function tarik()
    {
        return $this->hasMany('App\Tarik', 'id_nasabah');
    }

    public function riwayat_tabungan()
    {
        return $this->hasMany('App\RiwayatTabungan', 'id_nasabah');
    }

}
