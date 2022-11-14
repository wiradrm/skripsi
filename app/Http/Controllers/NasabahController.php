<?php

namespace App\Http\Controllers;

use DB;
use App\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    protected $page = 'admin.nasabah.';
    protected $index = 'admin.nasabah.index';

    public function index(Request $request)
    {
        $models = Nasabah::all();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nik'                  => 'required|max:16|unique:nasabah',
                'nama'                      => 'required',
                'tanggal_lahir'                      => 'required',
                'alamat'                    => 'required',
                'telp'                 => 'required|unique:nasabah',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'nik'                      => 'NIK',
                'nama'                      => 'Nama',
                'tanggal_lahir'              => 'Tanggal Lahir',
                'alamat'                    => 'Alamat',
                'telp'                 => 'No Telpon',
            ]
        );

        $model = new Nasabah();
        $model->nik = $request->nik;
        $model->nama = $request->nama;
        $model->tanggal_lahir = $request->tanggal_lahir;
        $model->alamat = $request->alamat;
        $model->telp = $request->telp;
        $model->save();

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'nik'                  => 'required|max:16|unique:nasabah,nik,'.$request->id,
                'nama'                      => 'required',
                'tanggal_lahir'                      => 'required',
                'alamat'                    => 'required',
                'telp'                 => 'required|unique:nasabah,telp',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'nik'                      => 'NIK',
                'nama'                      => 'Nama',
                'tanggal_lahir'              => 'Tanggal Lahir',
                'alamat'                    => 'Alamat',
                'telp'                 => 'No Telpon',
            ]
        );

        $model = Nasabah::findOrFail($id);
        $model->nik = $request->nik;
        $model->nama = $request->nama;
        $model->tanggal_lahir = $request->tanggal_lahir;
        $model->alamat = $request->alamat;
        $model->telp = $request->telp;
        $model->save();

        return redirect()->back()->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $model = Nasabah::findOrFail($id);
        DB::table('nasabah')->where('id',$id)->delete();
  
        return redirect()->route('nasabah')->with('info', 'Berhasil menghapus data');
    }

}
