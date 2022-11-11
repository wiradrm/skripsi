<?php

namespace App\Http\Controllers;

use App\TelurKandang;
use App\JenisKandang;
use App\JenisTelur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Exports\StockKandangExport;
use App\TransferStockKandang;
use Maatwebsite\Excel\Facades\Excel;

class StockKandangController extends Controller
{
    protected $page = 'admin.stock_kandang.';
    protected $index = 'admin.stock_kandang.index';

    public function index(Request $request)
    {

        $startDate = $request->from;
        $endDate = $request->to;
        
        $models = TelurKandang::latest('created_at');
        $jenis_kandang = JenisKandang::all();
        $jenis_telur = JenisTelur::all();

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $models = $models->get();

        return view($this->index, compact('models', 'jenis_kandang', 'jenis_telur'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'kedaluwarsa'                  => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'kedaluwarsa'                  => 'Kedaluwarsa',
            ]
        );

        $model = new TelurKandang();
        $model->id_user = Auth::user()->id;
        $model->id_jenis_kandang = $request->id_jenis_kandang;
        $model->id_jenis_telur = $request->id_jenis_telur;
        $model->satuan = $request->satuan;
        if (Auth::user()->level != 2) {
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $request->id_toko_gudang;
        }
        
        if($request->satuan == "Tray"){
            $model->jumlah = $request->jumlah * 30;
        } else {
            $model->jumlah = $request->jumlah;
        }
        $model->kedaluwarsa = $request->kedaluwarsa;
        if (!$request->created_at) {
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $request->created_at;
        }
        $model->save();

        return redirect()->route('stock_kandang')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'kedaluwarsa'                  => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'kedaluwarsa'                  => 'Kedaluwarsa',
            ]
        );

        $model = TelurKandang::findOrFail($id);
        $model->id_user = Auth::user()->id;
        $model->id_jenis_kandang = $request->id_jenis_kandang;
        $model->id_jenis_telur = $request->id_jenis_telur;
        $model->satuan = $request->satuan;
        if (Auth::user()->level != 2) {
            $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $model->id_toko_gudang = $request->id_toko_gudang;
        }
        if($request->satuan == "Tray"){
            $model->jumlah = $request->jumlah * 30;
        } else {
            $model->jumlah = $request->jumlah;
        }
        if (!$request->created_at) {
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $request->created_at;
        }
        $model->kedaluwarsa = $request->kedaluwarsa;
        $model->save();

        return redirect()->route('stock_kandang')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $transfer_kandang = TransferStockKandang::where('id_telur_masuk', $id)->get();
        if($transfer_kandang){
            foreach ($transfer_kandang as $key => $value) {
                $value->delete();
            }
         }
        $model = TelurKandang::findOrFail($id);
        $model->delete();

        return redirect()->route('stock_kandang')->with('info', 'Berhasil menghapus data');
    }

    public function export(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $item = TelurKandang::orderby('created_at', 'DESC')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        return Excel::download(new StockKandangExport($item), 'report_stock_in_' . date('d_m_Y_H_i_s') . '.xlsx');
    }
}
