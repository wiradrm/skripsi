<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisTelur;

class JenisTelurController extends Controller
{
    protected $page = 'admin.jenis_telur.';
    protected $index = 'admin.jenis_telur.index';

    public function index(Request $request)
    {
        $models = JenisTelur::all();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'jenis_telur'                      => 'required',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'jenis_telur'                      => 'Jenis Telur',
            ]
        );

        $model = new JenisTelur();
        $model->jenis_telur = $request->jenis_telur;
        $model->save();

        return redirect()->route('jenis_telur')->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'jenis_telur'                      => 'required',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'jenis_telur'                      => 'Jenis Telur',
            ]
        );

        $model = JenisTelur::findOrFail($id);
        $model->jenis_telur = $request->jenis_telur;
        $model->save();

        return redirect()->route('jenis_telur')->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = JenisTelur::findOrFail($id);
        $model->delete();
        return redirect()->route('jenis_telur')->with('info', 'Berhasil menghapus data');
    }
}
