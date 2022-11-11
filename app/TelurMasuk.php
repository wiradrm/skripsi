<?php

namespace App;

use App\JenisTelur;
use App\TokoGudang;
use App\TransferStock;
use App\TelurKeluar;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TelurMasuk extends Model
{
    public function getStock()
    {
        $stockin = TelurMasuk::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $this->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->sum('jumlah');

        $stocksubtotal = $stockin - $stockout;

        $checkbutir = $stocksubtotal % 30;
        $checktray = ($stocksubtotal - $checkbutir) / 30;

        if ($checkbutir == 0 && $checktray == 0) {
            echo 0;
        } else if ($checkbutir === 0) {
            echo $checktray . " Tray ";
        } else {
            echo $checktray . " Tray " . $checkbutir . " Butir";
        }
    }

    public function getJenisTelur()
    {
        return $this->belongsTo(JenisTelur::class, 'id_jenis_telur', 'id');
    }

    public function getTokoGudang()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_gudang', 'id');
    }

    public function getTokoTujuan()
    {
        return $this->belongsTo(TokoGudang::class, 'id_toko_tujuan', 'id');
    }

    public function checkStockTransfer()
    {
        $check = TransferStock::where('id_telur_masuk', $this->id)->first();
        return $check;
    }

    public function checkLastRecord()
    {
        $latest = TelurMasuk::latest('id')->pluck('id')->first();
        return $latest;
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

    public function showJumlah()
    {
        $checkbutir = $this->jumlah % 30;
        $checktray = ($this->jumlah - $checkbutir) / 30;

        if ($checkbutir == 0 && $checktray == 0) {
            echo 0;
        } else if ($checkbutir === 0) {
            echo $checktray . " Tray ";
        } else if ($this->jumlah < 30) {
            echo $this->jumlah . " Butir";
        } else {
            echo $checktray . " Tray " . $checkbutir . " Butir";
        }
    }

    public function getJumlah()
    {
        if ($this->satuan == "Tray") {
            $total = $this->jumlah / 30;
            $total = round($total);
        } else {
            $total = $this->jumlah;
        }

        return $total;
    }

    public function showDetails(){
        if(Auth::user()->level != 2){
            $details = TelurMasuk::where('id_toko_gudang', Auth::user()->id_toko_gudang)->where('id_jenis_telur', $this->id_jenis_telur)->get();
        } else {
            $details = TelurMasuk::where('id_jenis_telur', $this->id_jenis_telur)->get();
        }

        return $details;
    }

    public function showJumlahDetails()
    {
        $stockkeluar = TransferStock::where('id_telur_masuk', $this->id)->sum('jumlah');

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
