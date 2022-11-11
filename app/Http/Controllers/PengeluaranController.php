<?php

namespace App\Http\Controllers;

use App\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Exports\PengeluaranExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PengeluaranController extends Controller
{
    protected $page = 'admin.pengeluaran.';
    protected $index = 'admin.pengeluaran.index';

    public function index(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $models = Pengeluaran::where('id_toko_gudang', Auth::user()->id_toko_gudang);
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        $models = $models->get();

        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'subtotal'                     => 'required',
                'keterangan'                   => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'subtotal'                      => 'Subtotal',
                'keterangan'                    => 'Keterangan',
            ]
        );

        $model = new Pengeluaran();
        $model->id_user = Auth::user()->id;
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->subtotal = $request->subtotal;
        $model->keterangan = $request->keterangan;

        if(!$request->created_at){
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $request->created_at;
        }

        $model->save();

        if ($request->file('image') != null) {
            $file   = $request->file('image');
            $name   = Str::random(4) . '.' . strtolower($file->getClientOriginalExtension());
            $model->image = $name;
            $model->save();
            $model->uploadImage($file, $name);
        }

        return redirect()->route('pengeluaran')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'subtotal'                     => 'required',
                'keterangan'                   => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'subtotal'                      => 'Subtotal',
                'keterangan'                    => 'Keterangan',
            ]
        );

        $model = Pengeluaran::findOrFail($id);
        $model->id_user = Auth::user()->id;
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->subtotal = $request->subtotal;
        $model->keterangan = $request->keterangan;

        if(!$request->created_at){
            $model->created_at = Carbon::now();
        } else {
            $model->created_at = $request->created_at;
        }

        $model->save();

        if ($request->file('image') != null) {
            if($model->image){
                unlink("storage/image/nota/".$model->image);
            }
            $file   = $request->file('image');
            $name   = Str::random(4) . '.' . strtolower($file->getClientOriginalExtension());
            $model->image = $name;
            $model->save();
            $model->uploadImage($file, $name);
        }

        return redirect()->route('pengeluaran')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Pengeluaran::findOrFail($id);
        if($model->image){
            unlink("storage/image/nota/".$model->image);
        }
        $model->delete();
        return redirect()->route('pengeluaran')->with('info', 'Berhasil menghapus data');
    }

    public function export(Request $request){
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $item = Pengeluaran::orderby('created_at', 'DESC')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->where('id_toko_gudang', $toko)
        ->get();

        return Excel::download(new PengeluaranExport($item), 'report_pengeluaran_'.date('d_m_Y_H_i_s').'.xlsx');
    }
}
