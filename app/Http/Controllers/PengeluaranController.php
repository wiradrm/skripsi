<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Pengeluaran;
use Illuminate\Support\Facades\Hash;

class PengeluaranController extends Controller
{
    protected $page = 'admin.pengeluaran.';
    protected $index = 'admin.pengeluaran.index';

    public function index(Request $request)
    {
        $models = Pengeluaran::all();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'jenis_transaksi'                      => 'required',
                'jumlah'                      => 'required'

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'jenis_transaksi'                      => 'Jenis Transaksi',
                'jumlah'                      => 'Jumlah'
            ]
        );

        $model = new Pengeluaran();
        $model->jenis_transaksi = $request->jenis_transaksi;
        $model->jumlah = $request->jumlah;
        $model->save();

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'jenis_transaksi'                      => 'required',
                'jumlah'                      => 'required'


            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'jenis_transaksi'                      => 'Jenis Transaksi',
                'jumlah'                      => 'Jumlah'
            ]
        );

        $model = Pengeluaran::findOrFail($id);
        $model->jenis_transaksi = $request->jenis_transaksi;
        $model->jumlah = $request->jumlah;
        $model->save();

        return redirect()->route('pengeluaran')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Pengeluaran::findOrFail($id);
        DB::table('pengeluaran')->where('id',$id)->delete();
  
        return redirect()->route('pengeluaran')->with('info', 'Berhasil menghapus data');
    }

}
