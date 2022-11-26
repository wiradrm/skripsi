<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Nasabah;
use App\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    protected $page = 'admin.laporan.';
    protected $index = 'admin.laporan.simpanan';
    protected $pinjam = 'admin.laporan.pinjaman';
    protected $tunggakan = 'admin.laporan.surat.tunggakan';
    protected $print = 'admin.laporan.surat.print';

    public function index_simpanan(Request $request)
    {
        $models = Tabungan::all();
        return view($this->index, compact('models'));
    }

    public function index_pinjaman(Request $request)
    {

        $models = DB::table('pinjam')
                        ->join('hutang', 'pinjam.no_pinjam', '=', 'hutang.no_pinjam')
                        ->join('nasabah', 'nasabah.id', '=', 'pinjam.id_nasabah')
                        ->get();
        return view($this->pinjam, compact('models'));
    }


    public function index_tunggakan()
    {
        $models = Surat::all();
        $nasabah = Nasabah::all();

        return view($this->tunggakan, compact('models' , 'nasabah'));
    }

    public function store(Request $request)
    {

        $model = new Surat();
        $model->nama = $request->nama;
        $model->tanggal = $request->tanggal;
        $model->periode = $request->periode;
        $model->jumlah = $request->jumlah;
        $model->lama = $request->lama;
        $model->save();

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }


    public function cetak($id)
    {
        $data = Surat::where('id', $id)->first();


        $pdf = PDF::loadview($this->print, ['data' => $data]);

        return $pdf->stream('cetak_surat.pdf');
    }

    public function destroy($id)
    {
        $model = Surat::findOrFail($id);
        DB::table('surat')->where('id',$id)->delete();
  
        return redirect()->route('laporan.tunggakan')->with('info', 'Berhasil menghapus data');
    }


}
