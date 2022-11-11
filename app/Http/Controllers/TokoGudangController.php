<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TokoGudang;

class TokoGudangController extends Controller
{
    protected $page = 'admin.toko_gudang.';
    protected $index = 'admin.toko_gudang.index';

    public function index(Request $request)
    {
        $models = TokoGudang::all();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'nama'                      => 'required',
                'alamat'                    => 'required',
                'type'                      => 'required',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'nama'                      => 'Nama',
                'alamat'                    => 'Alamat',
                'type'                      => 'Type',
            ]
        );

        $model = new TokoGudang();
        $model->nama = $request->nama;
        $model->alamat = $request->alamat;
        $model->type = $request->type;
        $model->save();

        return redirect()->route('toko_gudang')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'nama'                      => 'required',
                'alamat'                    => 'required',
                'type'                      => 'required',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'nama'                      => 'Nama',
                'alamat'                    => 'Alamat',
                'type'                      => 'Type',
            ]
        );

        $model = TokoGudang::findOrFail($id);
        $model->nama = $request->nama;
        $model->alamat = $request->alamat;
        $model->type = $request->type;
        $model->save();

        return redirect()->route('toko_gudang')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = TokoGudang::findOrFail($id);
        $model->delete();
        return redirect()->route('toko_gudang')->with('info', 'Berhasil menghapus data');
    }
}
