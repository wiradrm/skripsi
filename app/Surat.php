<?php

namespace App;

use App\Surat;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';


    public function checkLastRecord(){
        $latest = Surat::latest('id')->pluck('id')->first();
        return $latest;
    }

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

}
