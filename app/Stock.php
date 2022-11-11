<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TelurMasuk;
use App\TelurKeluar;
class Stock extends Model
{
    public function getStock()
    {   
        $stockin = TelurMasuk::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        
        $stocksubtotal = $stockin - $stockout;

        $checkbutir = $stocksubtotal % 30;
        $checktray = ($stocksubtotal - $checkbutir) / 30;

        echo $checktray + " Tray " + $checkbutir + " Butir";
    }

    public function getStockTray()
    {   
        $stockin = TelurMasuk::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        
        $stock = $stockin - $stockout;

        $stock = $stock / 30;
        $stock = round($stock);

        return $stock;
    }

    public function getStockButir()
    {   
        $stockin = TelurMasuk::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        
        $stock = $stockin - $stockout;

        return $stock;
    }
}
