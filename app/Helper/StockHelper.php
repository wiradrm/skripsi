<?php

namespace App\Helper;

use App\JenisTelur;
use App\TelurKeluar;
use App\TelurMasuk;
use App\TransferStock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StockHelper{
    public static function transfers($jumlah, $id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $satuan, $id_penjualan, $created_at)
    {
        $jenis = JenisTelur::find($id_jenis_telur);
        // $models = $jenis->getStockActive;
        $getActive = TelurMasuk::where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->orderBy('id', 'desc')->get();
        foreach ($getActive as $key => $item) {
            $checkActive = TransferStock::where('id_telur_masuk', $item->id)->sum('jumlah');
            $jumlahActive =  $item->jumlah - $checkActive;
            if ($jumlahActive > 0) {
                $active = $item->id;
                $models = $item;
            }
        }

        // if($models){
        //     if($id_toko_gudang == $models->id_toko_gudang){
        //         $checkNextactive = TelurMasuk::where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->where('id', '>', $models->id)->get();
        //         if($models->jumlah <= 0 && $checkNextactive){
        //             $active = $models->id;
        //         }
        //     }
        // } else {
        //     $models = $othermodels;
        // }

        $jumlahs = TransferStock::where('id_telur_masuk', $active)->sum('jumlah');
        $cekstocktoko = TelurMasuk::where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->sum('jumlah');
        if($cekstocktoko >= $jumlah && $jenis->id_stock_active != 0){
            $selisih = $models->jumlah - $jumlahs;
            if($selisih >= $jumlah){
                $stock = new TelurKeluar();
                $stock->id_user = Auth::user()->id;
                $stock->id_jenis_telur = $id_jenis_telur;
                if(Auth::user()->level != 2){
                    $stock->id_toko_gudang = Auth::user()->id_toko_gudang;
                } else {
                    $stock->id_toko_gudang = $id_toko_gudang;
                }
                $stock->id_toko_tujuan = $id_toko_tujuan;
                $stock->satuan = $satuan;
                $stock->jumlah = $jumlah;
                $stock->id_penjualan = $id_penjualan;
                if(Auth::user()->level != 2){
                    $stock->id_toko_gudang = Auth::user()->id_toko_gudang;
                } else {
                    $stock->id_toko_gudang = $id_toko_gudang;
                }
                $stock->save();
    
                $transfer = new TransferStock;
                $transfer->id_telur_masuk = $active;
                $transfer->id_telur_keluar = $stock->id;
                $transfer->jumlah = $stock->jumlah;
                $transfer->id_penjualan = $id_penjualan;
                $transfer->save(); 
            } else {
                $stocklain = TelurMasuk::where('id', '>', $active)->where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->sum('jumlah');
                $stocklain_a = TelurMasuk::where('id', '>', $active)->where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->get();
                $jumlahsisa = $selisih + $stocklain;
                if($jumlahsisa >= $jumlah){
                    $stockterbaru = $jumlah - $selisih; 
    
                    $stock = new TelurKeluar();
                    $stock->id_user = Auth::user()->id;
                    $stock->id_jenis_telur = $id_jenis_telur;
                    if(Auth::user()->level != 2){
                        $stock->id_toko_gudang = Auth::user()->id_toko_gudang;
                    } else {
                        $stock->id_toko_gudang = $id_toko_gudang;
                    }
                    $stock->id_toko_tujuan = $id_toko_tujuan;
                    $stock->satuan = $satuan;
                    $stock->jumlah = $jumlah;
                    $stock->id_penjualan = $id_penjualan;
                    if(!$created_at){
                        $stock->created_at = Carbon::now();
                    } else {
                        $stock->created_at = $created_at;
                    }
                    $stock->save();
        
                    $transfer = new TransferStock;
                    $transfer->id_telur_masuk = $active;
                    $transfer->id_telur_keluar = $stock->id;
                    $transfer->jumlah = $selisih;
                    $transfer->id_penjualan = $id_penjualan;
                    $transfer->save();
    
                    foreach ($stocklain_a as $key => $item) {
                        if($stockterbaru > 0){
                            $checkStockOut = TransferStock::where('id_telur_masuk', $item->id)->sum('jumlah');
                            $transfer = new TransferStock;
                            $transfer->id_telur_masuk = $item->id;
                            $transfer->id_telur_keluar = $stock->id;
                            if($stockterbaru >= ($item->jumlah - $checkStockOut)) {
                                $transfer->jumlah = ($item->jumlah - $checkStockOut);
                            } else {
                                $transfer->jumlah = $stockterbaru;
                            }
                            $transfer->id_penjualan = $id_penjualan;
                            $transfer->save();
    
                            $stockterbaru -= $transfer->jumlah; 
    
                            if($stockterbaru == 0){
                                $next = TelurMasuk::where('id', '>', $item->id)->where('id_jenis_telur', $id_jenis_telur)->where('id_toko_gudang', $id_toko_gudang)->first();
                                if($next){
                                    $jenistelur = JenisTelur::find($id_jenis_telur);
                                    $jenistelur->id_stock_active = $next->id;
                                    $jenistelur->save();
                                } else {
                                    $jenistelur = JenisTelur::find($id_jenis_telur);
                                    $jenistelur->id_stock_active = $item->id;
                                    $jenistelur->save();
                                }
                            } else {
                                $jenistelur = JenisTelur::find($id_jenis_telur);
                                $jenistelur->id_stock_active = $item->id;
                                $jenistelur->save();
                            }
                        }
                    }
    
                } else {
                    return response()->json(['error' => 'Stock Tidak Mencukupi', 'stock' => '']);
                }
            }
        } else {
            return response()->json(['error' => 'Stock Tidak Mencukupi', 'stock' => '']);
        }
        return response()->json(['error' => '', 'stock' => $stock]);
    }
}