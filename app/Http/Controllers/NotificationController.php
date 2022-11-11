<?php

namespace App\Http\Controllers;

use App\Notification;
use App\TelurKeluar;
use App\TelurMasuk;
use App\Hutang;
use App\Penjualan;
use App\TransferStock;
use App\Helper\PembelianHelpers;
use App\TelurKandang;
use App\TransferStockKandang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $page = 'admin.notification.';
    protected $index = 'admin.notification.index';

    public function index(Request $request)
    {
        $models = Notification::where('id_toko_gudang', Auth::user()->id_toko_gudang)->get();
        return view($this->index, compact('models'));
    }

    public function telur_masuk(Request $request, $id)
    {
        if(Auth::user()->level !== 2){
            $getTelurKeluarId = Notification::where('id', $id)->pluck('id_transaction')->first();
            $telurKeluar = TelurKeluar::where('id', $getTelurKeluarId)->first();
            $getTelurMasukId = TransferStock::where('id_telur_keluar', $getTelurKeluarId)->pluck('id_telur_masuk')->first();
            $getTelurKandangId = TransferStockKandang::where('id_penjualan', $telurKeluar->id_penjualan)->pluck('id_telur_kandang')->first();

            if(!$getTelurMasukId){
                $getkedaluwarsa = TelurKandang::where('id', $getTelurKandangId)->pluck('kedaluwarsa')->first();
            }
            else{
                $getkedaluwarsa = TelurMasuk::where('id', $getTelurMasukId)->pluck('kedaluwarsa')->first();
            }

            $getPenjualan = Penjualan::where('id_telur_keluar', $getTelurKeluarId)->first();
            $getHutang = Hutang::where('type_transaction', 2)->where('id_transaction', $getPenjualan->id)->first();
    
            if (Auth::user()->level != 2) {
                $id_toko_gudang = Auth::user()->id_toko_gudang;
            } else {
                $id_toko_gudang = $request->id_toko_gudang;
            }

            if($telurKeluar->satuan == "Tray"){
                $jumlah = $telurKeluar->jumlah / 30;
            } else {
                $jumlah = $telurKeluar->jumlah;
            }
            $createPembelian = PembelianHelpers::createPembelian($id_toko_gudang, $getPenjualan->harga, $telurKeluar->satuan, $jumlah, $getPenjualan->status_pembayaran, $getHutang ? $getHutang->pembayaran_awal : null, $getHutang ? $getHutang->tgl_pelunasan : null, "Gudang", $getPenjualan->image, Carbon::now(), $telurKeluar->id_jenis_telur, $getkedaluwarsa);
        }

        $notification = Notification::findOrFail($id);
        if(Auth::user()->level !== 2){
            $notification->read = 0;
        } else {
            $notification->readByOwner = 0;
        }
        $notification->save();

        return redirect()->route('pembelian')->with('info', 'Berhasil menambah data');
    }

    public function penjualan(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        if(Auth::user()->level !== 2){
            $notification->read = 0;
        } else {
            $notification->readByOwner = 0;
        }
        $notification->save();

        if(Auth::user()->level !== 2){
            return redirect()->route('hutang')->with('danger', 'Hutang sudah jatuh tempo');
        } else {
            return redirect()->route('laporan.hutang')->with('danger', 'Hutang sudah jatuh tempo');
        }
    }

    public function pembelian(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        if(Auth::user()->level !== 2){
            $notification->read = 0;
        } else {
            $notification->readByOwner = 0;
        }
        $notification->save();
        if(Auth::user()->level !== 2){
            return redirect()->route('hutang')->with('danger', 'Hutang sudah jatuh tempo');
        } else {
            return redirect()->route('laporan.hutang')->with('danger', 'Hutang sudah jatuh tempo');
        }
    }

    public function checkhutang(Request $request)
    {
        $hutang = Hutang::all();
        foreach ($hutang as $item) {
            $check = Carbon::create($item->created_at)->startOfDay()->diffInDays(carbon::parse($item->tgl_pelunasan)->startOfDay());
            if ($check == 0) {
                if ($item->type_transaction == 1) {
                    $checknotif = Notification::where('id_transaction', $item->id_transaction)->where('type', 3)->get();
                } else {
                    $checknotif = Notification::where('id_transaction', $item->id_transaction)->where('type', 2)->get();
                }
                if ($checknotif->count() === 0) {
                    $notification = new Notification();
                    if ($item->type_transaction == 1) {
                        $notification->type = 3;
                        $notification->title = "Hutang Pembelian";
                    } else {
                        $notification->type = 2;
                        $notification->title = "Hutang Penjualan";
                    }
                    $notification->id_user = Auth::user()->id;
                    $notification->id_toko_gudang = $item->id_toko_gudang;
                    $notification->id_transaction = $item->id_transaction;
                    $notification->read = 1;
                    $notification->readByOwner = 1;
                    $notification->save();
                }
            }
        }
    }
}
