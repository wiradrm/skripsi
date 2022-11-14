<?php

namespace App;

use App\Tarik;
use Illuminate\Database\Eloquent\Model;

class Tarik extends Model
{
    protected $table = 'tarik';

    
    public function checkLastRecord(){
        $latest = Tarik::latest('id')->pluck('id')->first();
        return $latest;
    }

    public function nasabah()
    {
        return $this->belongsTo('App\Nasabah', 'id_nasabah');
    }

}
