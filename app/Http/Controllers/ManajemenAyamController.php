<?php

namespace App\Http\Controllers;
use App\Ayam;
use App\JenisKandang;
use Illuminate\Http\Request;

class ManajemenAyamController extends Controller
{
    protected $page = 'admin.manajemen_ayam.';
    protected $index = 'admin.manajemen_ayam.index';

    public function index(Request $request)
    {
        $models = Ayam::all();
        $jenis_kandang = JenisKandang::all();
        return view($this->index, compact('models', 'jenis_kandang'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'id_jenis_kandang'      => 'required',
                'jumlah'                => 'required',
            ],
            [
                'required'              => ':attribute is required.'
            ],
            [
                'id_jenis_kandang'      => 'Jenis Kandang',
                'jumlah'                => 'Jumlah',
            ]
        );

        $model = new Ayam();
        $model->id_jenis_kandang = $request->id_jenis_kandang;
        $model->jumlah = $request->jumlah;
        $model->save();

        return redirect()->route('manajemen_ayam')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'id_jenis_kandang'      => 'required',
            'jumlah'                => 'required',
        ],
        [
            'required'              => ':attribute is required.'
        ],
        [
            'id_jenis_kandang'      => 'Jenis Kandang',
            'jumlah'                => 'Jumlah',
        ]
    );

        $model = Ayam::findOrFail($id);
        $model->id_jenis_kandang = $request->id_jenis_kandang;
        $model->jumlah = $request->jumlah;
        $model->save();

        return redirect()->route('manajemen_ayam')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Ayam::findOrFail($id);
        $model->delete();
        return redirect()->route('manajemen_ayam')->with('info', 'Berhasil menghapus data');
    }
}
