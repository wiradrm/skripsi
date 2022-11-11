<?php

namespace App;
use App\TelurKeluar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Penjualan extends Model
{
    public function getTelurKeluar()
    {
        return $this->belongsTo(TelurKeluar::class, 'id_telur_keluar', 'id');
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }

    public function checkLastRecord(){
        if(Auth::user()->level == 2){
            $latest = TelurKeluar::latest('id')->pluck('id_penjualan')->first();

        } else {
            $latest = TelurKeluar::where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('id')->pluck('id_penjualan')->first();
        }
        return $latest;
    }
}
