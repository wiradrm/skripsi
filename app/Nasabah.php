<?php

namespace App;

use App\Nasabah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Nasabah extends Model
{
    protected $table = 'nasabah';

    public function checkLastRecord(){
        if(Auth::user()->level == 2){
            $latest = Nasabah::latest('id')->pluck('id')->first();

        } else {
            $latest = Nasabah::where('id')->latest('id')->pluck('id')->first();
        }
        return $latest;
    }
}
