<?php

namespace App\Helper;

use App\Pembelian;
use App\Hutang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helper\HutangHelpers;
use App\Helper\TelurHelper;

class PembelianHelpers{
    public static function createPembelian($id_toko_gudang, $harga_beli, $satuan, $jumlah, $status_pembayaran, $pembayaran_awal, $tgl_pelunasan, $supplier, $image, $created_at, $id_jenis_telur, $kedaluwarsa)
    {
        $model = new Pembelian();
        $model->id_user = Auth::user()->id;

        if(Auth::user()->level != 2){
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $id_toko_gudang;
        }

        $model->harga_beli = $harga_beli;
        $model->subtotal = $harga_beli * $jumlah;
        $model->status_pembayaran = $status_pembayaran;
        $model->supplier = $supplier;

        if(!$created_at){
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $created_at;
        }

        $model->save();

        if ($image != null) {
            $file   = $image;
            $name   = Str::random(4) . '.' . strtolower($file->getClientOriginalExtension());
            $model->image = $name;
            $model->save();
            $model->uploadImage($file, $name);
        }

        // CREATE HUTANG
        if($status_pembayaran == 2){
            $createHutang = HutangHelpers::createHutang($id_toko_gudang, $model->id, 1, $model->subtotal, $pembayaran_awal, $tgl_pelunasan);
        }

        // CREATE TELUR MASUK
        $createTelurMasuk = TelurHelper::createTelurMasuk($id_jenis_telur, $id_toko_gudang, $satuan, $jumlah, $kedaluwarsa, $model->id, $created_at);

        $model->id_telur_masuk = $createTelurMasuk->id;
        $model->save();
    }
    public static function updatePembelian($id, $id_toko_gudang, $harga_beli, $satuan, $jumlah, $status_pembayaran, $pembayaran_awal, $tgl_pelunasan, $supplier, $image, $created_at, $id_jenis_telur, $kedaluwarsa)
    {
        $model = Pembelian::findOrFail($id);
        $model->id_user = Auth::user()->id;

        if(Auth::user()->level != 2){
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $id_toko_gudang;
        }

        $model->harga_beli = $harga_beli;
        $model->subtotal = $harga_beli * $jumlah;
        $model->status_pembayaran = $status_pembayaran;
        $model->supplier = $supplier;

        if(!$created_at){
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $created_at;
        }

        $model->save();
       
        if ($image != null) {
            $file   = $image;
            $name   = Str::random(4) . '.' . strtolower($file->getClientOriginalExtension());
            $model->image = $name;
            $model->save();
            $model->uploadImage($file, $name);
        }

        if($status_pembayaran == 2){
            $hutang = Hutang::where('type_transaction', 1)->where('id_transaction', $id)->first();
            if(!$hutang){
                $createHutang = HutangHelpers::createHutang($id_toko_gudang, $model->id, 1, $model->subtotal, $pembayaran_awal, $tgl_pelunasan);
            } else {
                $updateHutang = HutangHelpers::updateHutang($id, $id_toko_gudang, $model->id, 1, $model->subtotal, $pembayaran_awal, $tgl_pelunasan);
            }
        } else {
            $hutang = Hutang::where('type_transaction', 1)->where('id_transaction', $id)->first();
            if($hutang){
                $hutang->delete();
            }
        }
        
        // CREATE TELUR MASUK
        $updateTelurMasuk = TelurHelper::updateTelurMasuk($model->id_telur_masuk, $id_jenis_telur, $id_toko_gudang, $satuan, $jumlah, $kedaluwarsa, $model->id, $created_at);

        $model->id_telur_masuk = $updateTelurMasuk->id;
        $model->save();
    }
}