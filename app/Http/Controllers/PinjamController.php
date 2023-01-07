<?php

namespace App\Http\Controllers;

use App\Pinjam;
use App\Nasabah;
use App\Hutang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PinjamController extends Controller
{
    protected $page = 'admin.pinjam.';
    protected $index = 'admin.pinjam.index';

    public function index()
    {
        $models = Pinjam::all();
        $nasabah = Nasabah::all();
        return view($this->index, compact('models', 'nasabah'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_nasabah'                    => 'required',
                'no_pinjam'                    => 'required|unique:pinjam',
                'tanggal'                   => 'required',
                'pinjaman'                 => 'required|integer',
                'bunga'                 => 'required|between:0,99.99',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_nasabah'                    => 'Nasabah',
                'no_pinjam'                    => 'No Pinjam',
                'tanggal'                   => 'Tanggal',
                'pinjaman'                 => 'Pinjaman',
                'bunga'                 => 'Bunga',

            ]
        );

        DB::transaction(function () use ($request) {
            // Insert into pinjam
            $model = new Pinjam();
            $model->no_pinjam = $request->no_pinjam;
            $model->id_nasabah = $request->id_nasabah;
            $model->tanggal = $request->tanggal;
            $model->pinjaman = $request->pinjaman;
            $model->bunga = $request->bunga;
            $model->save();


            $hutang = new Hutang;
            $hutang->no_pinjam = $request->no_pinjam;
            $hutang->id_nasabah = $request->id_nasabah;
            $hutang->pinjaman = $request->pinjaman;
            $hutang->hutang = $request->pinjaman;
            $hutang->bunga = $request->bunga;

            $hutang->save();

        });

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function destroy($id)
    {
        $model = Pinjam::findOrFail($id);

        $delete_all = $model->no_pinjam;
        
        DB::table('pinjam')->where('id',$id)->delete();
        
        DB::table('hutang')->where('no_pinjam', $delete_all)->delete();
        DB::table('pembayaran')->where('no_pinjam', $delete_all)->delete();
                
        return redirect()->route('pinjam')->with('info', 'Berhasil menghapus data');
    }

}
