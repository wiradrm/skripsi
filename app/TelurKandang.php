<?php

namespace App;

use Illuminate\Support\Carbon;
use App\JenisTelur;
use App\JenisKandang;
use App\Ayam;
use App\TransferStockKandang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class TelurKandang extends Model
{
    public function getStock()
    {   
        $stockin = TelurKandang::sum('jumlah');
        $stockout = TransferStockKandang::sum('jumlah');
        
        $stocksubtotal = $stockin - $stockout;

        $checkbutir = $stocksubtotal % 30;
        $checktray = ($stocksubtotal - $checkbutir) / 30;

        if($checkbutir == 0 && $checktray == 0){
            echo 0;
        }
        else if($checkbutir === 0){
            echo $checktray . " Tray ";
        } else {
            echo $checktray . " Tray " . $checkbutir . " Butir";
        }
    }

    public function getJenisKandang()
    {
        return $this->belongsTo(JenisKandang::class, 'id_jenis_kandang', 'id');
    }

    public function showJumlah()
    {
        $checkbutir = $this->jumlah % 30;
        $checktray = ($this->jumlah - $checkbutir) / 30;

        if($checkbutir == 0 && $checktray == 0){
            echo 0;
        }
        else if($checkbutir === 0){
            echo $checktray . " Tray ";
        }
        else if($this->jumlah < 30){
            echo $this->jumlah . " Butir";
        } else {
            echo $checktray . " Tray " . $checkbutir . " Butir";
        }
    }

    public function getJumlah()
    {
        if($this->satuan == "Tray"){
            $total = $this->jumlah / 30;
            $total = round($total);
        }
        else {
            $total = $this->jumlah;
        }

        return $total;
    }

    public function getKedaluwarsa()
    {
        if ($this->kedaluwarsa > 0) {
            $remaining_days = Carbon::create(Carbon::now()->startOfDay())->startOfDay()->diffInDays(carbon::parse($this->kedaluwarsa)->startOfDay(), false);
        } else {
            $remaining_days = 0;
        }
        return $remaining_days;
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }

    public function getJenisTelur()
    {
        return $this->belongsTo(JenisTelur::class, 'id_jenis_telur', 'id');
    }

    public function checkStockTransfer(){
        $check = TransferStockKandang::where('id_telur_kandang', $this->id)->first();
        return $check;
    }

    public function getPersentaseBertelur()
    {

        $jumlahTelur = $this->jumlah;
        $jumlahAyam = Ayam::where('id_jenis_kandang', $this->id_jenis_kandang)->sum('jumlah');

        $hasil = (($jumlahTelur + 8) / $jumlahAyam) * 100;
        return number_format((float)$hasil, 2, '.', '');
    }

    public function showDetails(){
        $details = TelurKandang::where('id_jenis_telur', $this->id_jenis_telur)->get();
        return $details;
    }

    public function checkStock()
    {
        $stockkeluar = TransferStockKandang::where('id_telur_kandang', $this->id)->sum('jumlah');
        $total = $this->jumlah - $stockkeluar;

        return $total;
    }

    public function showJumlahDetails()
    {
        $stockkeluar = TransferStockKandang::where('id_telur_kandang', $this->id)->sum('jumlah');
        $total = $this->jumlah - $stockkeluar;

        $checkbutir = $total % 30;
        $checktray = ($total - $checkbutir) / 30;

        if ($checkbutir == 0 && $checktray == 0) {
            echo 0;
        } else if ($checkbutir === 0) {
            echo $checktray . " Tray ";
        } else if ($total < 30) {
            echo $total . " Butir";
        } else {
            echo $checktray . " Tray " . $checkbutir . " Butir";
        }
    }
}
