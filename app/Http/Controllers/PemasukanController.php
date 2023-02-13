<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Pemasukan;
use Illuminate\Support\Facades\Hash;

class PemasukanController extends Controller
{
    protected $page = 'admin.pemasukan.';
    protected $index = 'admin.pemasukan.index';

    public function index(Request $request)
    {
        $models = Pemasukan::all();
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

        $model = new Pemasukan();
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

        $model = Pemasukan::findOrFail($id);
        $model->jenis_transaksi = $request->jenis_transaksi;
        $model->jumlah = $request->jumlah;
        $model->save();

        return redirect()->route('pemasukan')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Pemasukan::findOrFail($id);
        DB::table('pemasukan')->where('id',$id)->delete();
  
        return redirect()->route('pemasukan')->with('info', 'Berhasil menghapus data');
    }

}
