<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TelurKeluar;
use App\TelurMasuk;
use App\JenisTelur;
use App\TokoGudang;
use App\TransferStock;
use App\Notification;
use App\TelurKandang;
use App\TransferStockKandang;

use App\Helper\StockHelper;
use App\Helper\TelurHelper;
use App\Helper\NotificationHelper;
use App\Helper\StockKandangHelper;
use App\Exports\StockInExport;
use App\Exports\StockOutExport;
use App\Exports\StockExport;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    protected $page = 'admin.stock.';
    protected $index = 'admin.stock.index';

    public function index(Request $request)
    {
        $jenisTelur = $request->jenis_telur;
        $models = new TelurMasuk();
        $stockKandang = new TelurKandang();

        if ($jenisTelur) {
            $models = $models->where('id_jenis_telur', $jenisTelur);
            $stockKandang = $stockKandang->where('id_jenis_telur', $jenisTelur);
        }
        if (Auth::user()->level != 2) {
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $stockKandang = $stockKandang->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }

        $models = $models->groupBy('id_jenis_telur')->get();
        $telurKandang = $stockKandang->groupBy('id_jenis_telur')->get();

        $models = $models->toBase()->merge($telurKandang);

        return view($this->index, compact('models'));
    }

    public function stock_in(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;
        $jenistelur = JenisTelur::all();
        $telurKandang = TelurKandang::get();

        if (Auth::user()->level == 2) {
            $tokogudang = TokoGudang::all();
        } else {
            $tokogudang = TokoGudang::where('id', Auth::user()->id_toko_gudang)->get();
        }
        if (Auth::user()->level != 2) {
            $models = TelurMasuk::where('id_pembelian', '==', 0)->where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('created_at');
        } else {
            $models = TelurMasuk::where('id_pembelian', '==', 0)->latest('created_at');
        }
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if ($toko) {
            $models = $models->where('id_toko_gudang', $toko);
        }
        $models = $models->get();

        return view('admin.stock_in.index', compact('models', 'jenistelur', 'tokogudang', 'telurKandang'));
    }

    public function stock_out(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;
        $jenistelur = JenisTelur::all(); 

        if (Auth::user()->level == 2) {
            $tokogudang = TokoGudang::all();
        } else {
            $tokogudang = TokoGudang::where('id', Auth::user()->id_toko_gudang)->get();
        }
        if (Auth::user()->level != 2) {
            $models = TelurKeluar::where('id_penjualan', '==', 0)->where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('created_at');
        } else {
            $models = TelurKeluar::where('id_penjualan', '==', 0)->latest('created_at');
        }
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if ($toko) {
            $models = $models->where('id_toko_gudang', $toko);
        }
        $models = $models->get();

        return view('admin.stock_out.index', compact('models', 'jenistelur', 'tokogudang'));
    }

    public function store_stock_in(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
            ]
        );
        if($request->satuan == "Tray"){
            $jumlah = $request->jumlah * 30;
        } else {
            $jumlah = $request->jumlah;
        }

        $checkStock = TelurKandang::where('id', $request->id_telur_kandang)->sum('jumlah');
        $checkTransfer = TransferStockKandang::where('id_telur_kandang', $request->id_telur_kandang)->sum('jumlah');
        $stock = $checkStock - $checkTransfer;
        $getSortirId = TelurKandang::where('id', $request->id_telur_kandang)->pluck('id_jenis_telur')->first();

        if($stock >= $jumlah){
            $createTelurMasuk = TelurHelper::createTelurMasuk($request->id_jenis_telur, $request->id_toko_gudang, $request->satuan, $request->jumlah, $request->kedaluwarsa, 0, $request->created_at);
            $stockKandangHelper = StockKandangHelper::transfers($request->id_telur_kandang, $createTelurMasuk->id, $jumlah, $getSortirId, Auth::user()->id_toko_gudang, 0, $request->satuan, 0);
            return redirect()->back()->with('info', 'Berhasil menambah data');
        }
        return redirect()->back()->with('error', 'Stock tidak mencukupi');
    }

    public function store_stock_out(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
            ]
        );

        if (Auth::user()->level != 2) {
            $id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $id_toko_gudang = $request->id_toko_gudang;
        }
        if ($request->satuan == "Tray") {
            $jumlah = $request->jumlah * 30;
        } else {
            $jumlah = $request->jumlah;
        }
        $stockHelper = StockHelper::transfers($jumlah, $request->id_jenis_telur, $id_toko_gudang, $request->id_toko_tujuan, $request->satuan, 0, $request->created_at);
        if ($stockHelper->id_toko_tujuan !== 0) {
            $createNotification = NotificationHelper::createNotification(1, $stockHelper->id_toko_tujuan, $stockHelper->id, "Telur Masuk", 1);
        }
        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update_stock_in(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
            ]
        );

        $transfer_kandang = TransferStockKandang::where('id_telur_masuk', $id)->get();

        $checkStock = TelurKandang::where('id_toko_gudang', Auth::user()->id_toko_gudang)->where('id', $request->id_telur_kandang)->sum('jumlah');
        $checkTransfer = TransferStockKandang::where('id_telur_kandang', $request->id_telur_kandang)->get()->sum('jumlah');
        $stock = $checkStock - $checkTransfer;

        $getSortirId = TelurKandang::where('id', $request->id_telur_kandang)->pluck('id_jenis_telur')->first();
    
        if($request->satuan == "Tray"){
            $jumlah = $request->jumlah * 30;
        } else {
            $jumlah = $request->jumlah;
        }

        if($stock >= $jumlah){
            if($transfer_kandang){
                foreach ($transfer_kandang as $key => $value) {
                    $value->delete();
                }

                $delete = TelurMasuk::find($id);
                $delete->delete();
            }

            $createTelurMasuk = TelurHelper::createTelurMasuk($request->id_jenis_telur, $request->id_toko_gudang, $request->satuan, $request->jumlah, $request->kedaluwarsa, 0, $request->created_at);
            $stockKandangHelper = StockKandangHelper::transfers($request->id_telur_kandang, $createTelurMasuk->id, $jumlah, $getSortirId, Auth::user()->id_toko_gudang, 0, $request->satuan, 0);
            return redirect()->back()->with('info', 'Berhasil menambah data');
        }
        return redirect()->back()->with('error', 'Stock tidak mencukupi');
    }

    public function update_stock_out(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
            ]
        );

        if ($request->satuan == "Tray") {
            $jumlah = $request->jumlah;
            $jumlah = $jumlah * 30;
        } else {
            $jumlah = $request->jumlah;
        }

        $transfer = TransferStock::where('id_telur_keluar', $request->id)->get();
        foreach ($transfer as $key => $value) {
            $value->delete();
        }

        $model = TelurKeluar::find($request->id);
        $model->delete();

        if (Auth::user()->level != 2) {
            $id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $id_toko_gudang = $request->id_toko_gudang;
        }
        $stockHelper = StockHelper::transfers($jumlah, $request->id_jenis_telur, $id_toko_gudang, $request->id_toko_tujuan, $request->satuan, 0, $request->created_at);

        if ($stockHelper->id_toko_tujuan !== 0) {
            $createNotification = NotificationHelper::updateNotification($id, $stockHelper->id);
        }

        return redirect()->back()->with('info', 'Berhasil mengubah data');
    }

    public function destroy_stock_in($id)
    {
        $model = TelurMasuk::find($id);
        $transfer = TransferStock::where('id_telur_masuk', $model->id)->get();
        $transfer_kandang = TransferStockKandang::where('id_telur_masuk', $id)->get();
        if($transfer || $transfer_kandang){
            $getTelurKandangId = TransferStockKandang::where('id_telur_masuk', $id)->pluck('id_telur_kandang')->first();
            $telurKeluar = TelurKeluar::where('id_telur_kandang', $getTelurKandangId)->get();
            foreach ($telurKeluar as $key => $value) {
                $value->delete();
            }

            foreach ($transfer_kandang as $key => $value) {
                $value->delete();
            }

            foreach ($transfer as $key => $value) {
                $value->delete();
                $stockout = TelurMasuk::where('id', $value->id_telur_keluar);
                $stockout->delete();
            }
   
        }

        $jenistelur = JenisTelur::find($model->id_jenis_telur);
        $stock = TelurMasuk::where('id_jenis_telur', $model->id_jenis_telur)->first();
        if ($stock == null) {
            $jenistelur->id_stock_active = 0;
        } else {
            $jenistelur->id_stock_active = $stock->id;
        }
        $jenistelur->save();
        $model->delete();

        return redirect()->back()->with('info', 'Berhasil menghapus data');
    }

    public function destroy_stock_out($id)
    {
        $model = TelurKeluar::find($id);
        $model->delete();

        $transfer = TransferStock::where('id_telur_keluar', $model->id)->get();
        foreach ($transfer as $key => $value) {
            $value->delete();
        }

        $notification = Notification::where('type', 1)->where('id_transaction', $id)->first();
        $notification->delete();

        return redirect()->back()->with('info', 'Berhasil menghapus data');
    }

    public function stock_in_export(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $item = TelurMasuk::orderby('created_at', 'DESC')
            ->where('id_pembelian', 0)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        return Excel::download(new StockInExport($item), 'report_stock_in_' . date('d_m_Y_H_i_s') . '.xlsx');
    }

    public function stock_out_export(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $item = TelurKeluar::orderby('created_at', 'DESC')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        return Excel::download(new StockOutExport($item), 'report_stock_out_' . date('d_m_Y_H_i_s') . '.xlsx');
    }

    public function stock_export(Request $request)
    {
        $jenis_telur = $request->id_jenis_telur;
        $toko = $request->id_toko_gudang;

        $item = TelurMasuk::orderby('created_at', 'DESC')
            ->where('id_jenis_telur', $jenis_telur)
            ->where('id_toko_gudang', $toko)
            ->groupBy('id_jenis_telur')
            ->get();

        if($item->count() == 0){
            $item = TelurKandang::orderby('created_at', 'DESC')
            ->where('id_jenis_telur', $jenis_telur)
            ->where('id_toko_gudang', $toko)
            ->groupBy('id_jenis_telur')
            ->get();
        }

        return Excel::download(new StockExport($item), 'report_stock_' . date('d_m_Y_H_i_s') . '.xlsx');
    }
}
