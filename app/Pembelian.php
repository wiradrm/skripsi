<?php

namespace App;
use App\TokoGudang;
use App\TelurMasuk;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    public function getTelurMasuk()
    {
        return $this->belongsTo(TelurMasuk::class, 'id_telur_masuk', 'id');
    }

    public function checkStockTransfer(){
        $check = TransferStock::where('id_telur_masuk', $this->id)->first();
        return $check;
    }

    public function checkLastRecord(){
        $latest = Pembelian::latest('id')->pluck('id')->first();
        return $latest;
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }
    
    public function uploadImage($image, $name)
    {
        $des    = 'storage/image/nota/';
        $image->move($des, $name);
    }

    public function getImage()
    {
        $path   = 'storage/image/nota/';
        return url($path . $this->image);
    }
}
