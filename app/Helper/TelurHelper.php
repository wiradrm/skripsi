<?php

namespace App\Helper;

use App\JenisTelur;
use App\TelurMasuk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TelurHelper
{
    public static function createTelurMasuk($id_jenis_telur, $id_toko_gudang, $satuan, $jumlah, $kedaluwarsa, $id_pembelian, $created_at)
    {
        $model = new TelurMasuk();
        $model->id_user = Auth::user()->id;
        $model->id_jenis_telur = $id_jenis_telur;

        if (Auth::user()->level != 2) {
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $id_toko_gudang;
        }

        $model->satuan = $satuan;

        if ($satuan == "Tray") {
            $jumlah = $jumlah * 30;
        } else {
            $jumlah = $jumlah;
        }

        $model->jumlah = $jumlah;
        $model->kedaluwarsa = $kedaluwarsa;
        $model->id_pembelian = $id_pembelian;

        if (!$created_at) {
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $created_at;
        }

        $model->save();

        $jenistelur = JenisTelur::find($id_jenis_telur);
        if ($jenistelur->id_stock_active == 0) {
            $stock = TelurMasuk::where('id_jenis_telur', $id_jenis_telur)->first();
            $jenistelur->id_stock_active = $stock->id;
            $jenistelur->save();
        }

        return $model;
    }

    public static function updateTelurMasuk($id, $id_jenis_telur, $id_toko_gudang, $satuan, $jumlah, $kedaluwarsa, $id_pembelian, $created_at)
    {
        $model = TelurMasuk::where('id',$id)->first();
        $model->id_user = Auth::user()->id;
        $model->id_jenis_telur = $id_jenis_telur;

        if (Auth::user()->level != 2) {
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $id_toko_gudang;
        }

        $model->satuan = $satuan;

        if ($satuan == "Tray") {
            $jumlah = $jumlah * 30;
        } else {
            $jumlah = $jumlah;
        }

        $model->jumlah = $jumlah;
        $model->kedaluwarsa = $kedaluwarsa;
        $model->id_pembelian = $id_pembelian;

        if (!$created_at) {
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $created_at;
        }

        $model->save();

        return $model;
    }
}
