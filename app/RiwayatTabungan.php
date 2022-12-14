<?php

namespace App;

use App\Tabungan;
use App\RiwayatTabungan;

use Illuminate\Database\Eloquent\Model;

class RiwayatTabungan extends Model
{
    protected $table = 'riwayat_tabungan';

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

    public function tabungan()
    {
        return $this->belongsTo('App\Tabungan', 'id_nasabah');
    }

    public function showDetails(){
        
        $details = RiwayatTabungan::where('id_nasabah', $this->id_nasabah)->get();

        return $details;
    }
}
