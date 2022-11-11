<?php

namespace App;

use App\JenisTelur;
use App\TokoGudang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    public function getJenisTelur()
    {
        return $this->belongsTo(JenisTelur::class, 'id_jenis_telur', 'id');
    }

    public function checkHargaTelur()
    {
        $harga = Harga::where('id', $this->id)->where('id_toko_gudang', Auth::user()->id_toko_gudang)->first();
        if($harga){
            return true;
        } else {
            return false;
        }
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }
}
