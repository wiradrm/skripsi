<?php

namespace App\Http\Controllers;

use App\JenisKandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisKandangController extends Controller
{
    protected $page = 'admin.jenis_kandang.';
    protected $index = 'admin.jenis_kandang.index';

    public function index(Request $request)
    {
        $models = JenisKandang::all();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'jenis_kandang'    => 'required',

            ],
            [
                'required'         => ':attribute is required.'
            ],
            [
                'jenis_kandang'    => 'Jenis Kandang',
            ]
        );

        $model = new JenisKandang();
        $model->id_user = Auth::user()->id;
        $model->jenis_kandang = $request->jenis_kandang;
        $model->save();

        return redirect()->route('jenis_kandang')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'jenis_kandang'    => 'required',

            ],
            [
                'required'         => ':attribute is required.'
            ],
            [
                'jenis_kandang'    => 'Jenis Kandang',
            ]
        );

        $model = JenisKandang::findOrFail($id);
        $model->jenis_kandang = $request->jenis_kandang;
        $model->save();

        return redirect()->route('jenis_kandang')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = JenisKandang::findOrFail($id);
        $model->delete();
        return redirect()->route('jenis_kandang')->with('info', 'Berhasil menghapus data');
    }
}
