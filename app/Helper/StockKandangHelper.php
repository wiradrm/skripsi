<?php

namespace App\Helper;

use App\TelurKandang;
use App\TelurKeluar;
use App\TransferStockKandang;
use Illuminate\Support\Facades\Auth;

class StockKandangHelper
{
    public static function transfers($id_telur_kandang, $id_telur_masuk, $jumlah, $id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $satuan, $id_penjualan)
    {
        $cekstockkandang = TelurKandang::sum('jumlah');
        $getDate = TelurKandang::where('id', $id_telur_kandang)->pluck('created_at');

        $getActive = TelurKandang::orderBy('id', 'desc')->get();
        if ($id_telur_kandang === 0) {
            foreach ($getActive as $key => $item) {
                $checkActive = TransferStockKandang::where('id_telur_kandang', $item->id)->sum('jumlah');
                $jumlahActive =  $item->jumlah - $checkActive;
                if ($jumlahActive > 0) {
                    $active = $item;
                }
            }
        }

        if ($id_telur_kandang) {
            $active = TelurKandang::where('id', $id_telur_kandang)->first();
        }

        $jumlahs = TransferStockKandang::where('id_telur_kandang', $active->id)->sum('jumlah');
        $models = TelurKandang::where('id', $active->id)->sum('jumlah');

        if ($cekstockkandang >= $jumlah) {
            $selisih = $models - $jumlahs;
            if ($selisih >= $jumlah) {
                $stock = new TelurKeluar();
                $stock->id_user = Auth::user()->id;
                $stock->id_jenis_telur = $id_jenis_telur;
                if ($id_telur_kandang) {
                    $stock->id_telur_kandang = $id_telur_kandang;
                } else {
                    $stock->id_telur_kandang = $active->id;
                }
                $stock->id_toko_gudang = $id_toko_gudang;
                $stock->id_toko_tujuan = $id_toko_tujuan;
                $stock->satuan = $satuan;
                $stock->jumlah = $jumlah;
                $stock->id_penjualan = $id_penjualan;
                $stock->save();

                $model = new TransferStockKandang();
                if ($id_telur_kandang === 0) {
                    $model->id_telur_kandang = $active->id;
                } else {
                    $model->id_telur_kandang = $id_telur_kandang;
                }
                $model->id_telur_masuk = $id_telur_masuk;
                $model->id_penjualan = $id_penjualan;
                $model->jumlah = $jumlah;
                $model->save();
            } else {
                $stocklain = TelurKandang::where('id', '>', $active->id)->sum('jumlah');
                $stocklain_a = TelurKandang::where('id', '>', $active->id)->get();

                if ($id_telur_kandang) {
                    $stocklain = TelurKandang::whereDate('created_at', $getDate)->where('id', '>', $active->id)->sum('jumlah');
                    $stocklain_a = TelurKandang::whereDate('created_at', $getDate)->where('id', '>', $active->id)->get();
                }

                $jumlahsisa = $selisih + $stocklain;
                if ($jumlahsisa >= $jumlah) {
                    $stockterbaru = $jumlah - $selisih;
                    $stock = new TelurKeluar();
                    $stock->id_user = Auth::user()->id;
                    $stock->id_jenis_telur = $id_jenis_telur;
                    if ($id_telur_kandang) {
                        $stock->id_telur_kandang = $id_telur_kandang;
                    } else {
                        $stock->id_telur_kandang = $active->id;
                    }
                    $stock->id_toko_gudang = $id_toko_gudang;
                    $stock->id_toko_tujuan = $id_toko_tujuan;
                    $stock->satuan = $satuan;
                    $stock->jumlah = $jumlah;
                    $stock->id_penjualan = $id_penjualan;
                    $stock->save();

                    $model = new TransferStockKandang();
                    if ($id_telur_kandang === 0) {
                        $model->id_telur_kandang = $active->id;
                    } else {
                        $model->id_telur_kandang = $id_telur_kandang;
                    }
                    $model->id_telur_masuk = $id_telur_masuk;
                    $model->id_penjualan = $id_penjualan;
                    $model->jumlah = $selisih;
                    $model->save();

                    foreach ($stocklain_a as $key => $item) {
                        $checkStockLain = TransferStockKandang::where('id_telur_kandang', $item->id)->sum('jumlah');
                        $getRealStock = $item->jumlah - $checkStockLain;
                        if ($stockterbaru > 0) {
                            $model = new TransferStockKandang();
                            $model->id_telur_kandang = $item->id;
                            $model->id_telur_masuk = $id_telur_masuk;
                            if ($stockterbaru >= $getRealStock) {
                                $model->jumlah = $getRealStock;
                            } else {
                                $model->jumlah = $stockterbaru;
                            }
                            $model->id_telur_masuk = $id_telur_masuk;
                            $model->id_penjualan = $id_penjualan;
                            $model->save();
                            $stockterbaru -= $getRealStock;
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
