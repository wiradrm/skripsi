<?php

namespace App\Helper;

use App\Hutang;
use Illuminate\Support\Facades\Auth;

class HutangHelpers{
    public static function createHutang($id_toko_gudang, $id_transaction, $type_transaction, $subtotal, $pembayaran_awal, $tgl_pelunasan, $id_customer)
    {
        $hutang = new Hutang();
        $hutang->id_user = Auth::user()->id;

        if(Auth::user()->level != 2){
            $hutang->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $hutang->id_toko_gudang = $id_toko_gudang;
        }

        $hutang->id_transaction = $id_transaction;
        $hutang->id_customer = $id_customer;
        $hutang->type_transaction = $type_transaction;
        $hutang->pembayaran_awal = $pembayaran_awal;
        $hutang->sisa_pembayaran = ($subtotal - $pembayaran_awal);
        $hutang->tgl_pelunasan = $tgl_pelunasan;
        $hutang->save();
    }
    public static function updateHutang($id, $id_toko_gudang, $id_transaction, $type_transaction, $subtotal, $pembayaran_awal, $tgl_pelunasan, $id_customer)
    {
        $hutang = Hutang::where('type_transaction', $type_transaction)->where('id_transaction', $id)->first();
        $hutang->id_user = Auth::user()->id;

        if(Auth::user()->level != 2){
            $hutang->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $hutang->id_toko_gudang = $id_toko_gudang;
        }

        $hutang->id_transaction = $id_transaction;
        $hutang->id_customer = $id_customer;
        $hutang->type_transaction = $type_transaction;
        $hutang->pembayaran_awal = $pembayaran_awal;
        $hutang->sisa_pembayaran = ($subtotal - $pembayaran_awal);
        $hutang->tgl_pelunasan = $tgl_pelunasan;
        $hutang->save();
    }
}
