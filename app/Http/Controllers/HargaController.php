<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Harga;
use App\JenisTelur;
use App\TokoGudang;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Carbon;
use App\Exports\HargaExport;
use Maatwebsite\Excel\Facades\Excel;
class HargaController extends Controller
{
    protected $page = 'admin.harga.';
    protected $index = 'admin.harga.index';

    public function index(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $jenistelur = JenisTelur::all();

        $models = Harga::where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('id');
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        $models = $models->get();

        return view($this->index, compact('models', 'jenistelur'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'id_jenis_telur'                      => 'required',
                'harga_jual_per_tray'                     => 'required',
                'harga_gudang_per_tray'                   => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'                      => 'Jenis Telur',
                'harga_jual_per_tray'                     => 'Harga Toko per Tray',
                'harga_gudang_per_tray'                   => 'Harga Gudang per Tray',
            ]
        );

        $model = new Harga();
        $model->id_user = Auth::user()->id;
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->id_jenis_telur = $request->id_jenis_telur;
        $model->harga_jual_per_tray = $request->harga_jual_per_tray;
        $model->harga_gudang_per_tray = $request->harga_gudang_per_tray;

        if(!$request->created_at){
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $request->created_at;
        }

        $model->save();

        return redirect()->route('harga')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'id_jenis_telur'                      => 'required',
                'harga_jual_per_tray'                     => 'required',
                'harga_gudang_per_tray'                   => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'                      => 'Jenis Telur',
                'harga_jual_per_tray'                     => 'Harga Toko per Tray',
                'harga_gudang_per_tray'                   => 'Harga Gudang per Tray',
            ]
        );

        $model = Harga::findOrFail($id);
        $model->id_user = Auth::user()->id;
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->id_jenis_telur = $request->id_jenis_telur;
        $model->harga_jual_per_tray = $request->harga_jual_per_tray;
        $model->harga_gudang_per_tray = $request->harga_gudang_per_tray;
        $model->created_at = $request->created_at;
        $model->save();

        return redirect()->route('harga')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Harga::findOrFail($id);
        $model->delete();
        return redirect()->route('harga')->with('info', 'Berhasil menghapus data');
    }

    public function export(Request $request){
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $item = Harga::orderby('created_at', 'DESC')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->where('id_toko_gudang', $toko)
        ->get();

        return Excel::download(new HargaExport($item), 'report_harga_'.date('d_m_Y_H_i_s').'.xlsx');
    }
}
