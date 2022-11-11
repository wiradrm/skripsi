<?php

namespace App;

use App\TelurKeluar;
use App\Penjualan;
use App\Pembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    public function getTransaction()
    {
        if($this->type == 1){
            return $this->belongsTo(TelurKeluar::class, 'id_transaction', 'id');
        } else if($this->type == 2) {
            return $this->belongsTo(Penjualan::class, 'id_transaction', 'id');
        } else {
            return $this->belongsTo(Pembelian::class, 'id_transaction', 'id');
        }
    }

    public function getContent()
    {
        if($this->type == 1){
            $telurkeluar = TelurKeluar::where('id', $this->id_transaction)->pluck('jumlah')->first();
            $checkbutir = $telurkeluar % 30;
            $checktray = ($telurkeluar - $checkbutir) / 30;
    
            if($checkbutir === 0){
                echo $checktray . " Tray ";
            }
            else if($telurkeluar < 30){
                echo $telurkeluar . " Butir";
            } else {
                echo $checktray . " Tray " . $checkbutir . " Butir";
            }
        } else if($this->type == 2){
            $penjualan = Penjualan::where('id', $this->id_transaction)->first();
            if(Auth::user()->level == 2){
                echo $penjualan->customer." di ".$penjualan->getTokoGudang->nama." jatuh tempo hari ini";
            } else {
                echo $penjualan->customer." jatuh tempo hari ini";
            }
        } else {
            $pembelian = Pembelian::where('id', $this->id_transaction)->first();
            if(Auth::user()->level == 2){
                echo $pembelian->supplier." di ".$pembelian->getTokoGudang->nama." jatuh tempo hari ini";
            } else {
                echo $pembelian->supplier." jatuh tempo hari ini";
            }
        }
    }
}
