<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Hutang;
use App\Pembelian;
use App\Penjualan;
use App\Exports\HutangExport;
use Maatwebsite\Excel\Facades\Excel;

class HutangController extends Controller
{
    protected $page = 'admin.hutang.';
    protected $index = 'admin.hutang.index';

    public function index(Request $request)
    {
        $typeTransactions = $request->type_transaction;

        $models = Hutang::latest('created_at');
        if($typeTransactions){
            $models = $models->where('type_transaction', $typeTransactions);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();

        return view($this->index, compact('models'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'pembayaran_awal'              => 'required',
                'tgl_pelunasan'                => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'pembayaran_awal'              => 'Pembayaran Awal',
                'tgl_pelunasan'                => 'Tanggal Pelunasan',
            ]
        );

        $models = Hutang::findOrFail($id);
        $models->id_customer = $request->id_customer;
        $models->id_user = Auth::user()->id;
        $models->id_toko_gudang = Auth::user()->id_toko_gudang;
        $models->pembayaran_awal = $request->pembayaran_awal;
        $models->sisa_pembayaran = ($request->subtotal - $request->pembayaran_awal);
        $models->tgl_pelunasan = $request->tgl_pelunasan;
        $models->created_at = $request->created_at;
        $models->save();

        if($request->subtotal <= $models->pembayaran_awal){
            $hutang = Hutang::findOrFail($models->id);
            $hutang->delete();
            if($models->type_transaction == 1){
                $pembelian = Pembelian::findOrFail($models->id_transaction);
                $pembelian->status_pembayaran = 1;
                $pembelian->save();
            }
    
            if($models->type_transaction == 2){
                $pembelian = Penjualan::findOrFail($models->id_transaction);
                $pembelian->status_pembayaran = 1;
                $pembelian->paid = $models->pembayaran_awal;
                $pembelian->change = $pembelian->paid - $request->subtotal;
                $pembelian->save();
            }
        }

        return redirect()->back()->with('info', 'Berhasil mengubah data');
    }

    public function export(Request $request){
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;
        $type_transaction = $request->type_transaction;

        $item = Hutang::orderby('created_at', 'DESC')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->where('id_toko_gudang', $toko)
        ->where('type_transaction', $type_transaction)
        ->get();

        return Excel::download(new HutangExport($item), 'report_hutang_'.date('d_m_Y_H_i_s').'.xlsx');
    }
}
