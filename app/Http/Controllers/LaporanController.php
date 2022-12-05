<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Nasabah;
use App\Surat;
use App\RiwayatTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

use App\Exports\SimpananExport;


class LaporanController extends Controller
{
    protected $page = 'admin.laporan.';
    protected $index = 'admin.laporan.simpan.simpanan';
    protected $index_detail = 'admin.laporan.simpan.detail';
    protected $pinjam = 'admin.laporan.pinjaman.pinjaman';
    protected $tunggakan = 'admin.laporan.surat.tunggakan';
    protected $print = 'admin.laporan.surat.print';

    public function index_simpanan(Request $request)
    {
        $nasabah = Nasabah::all();
        return view($this->index, compact('nasabah'));
    }

    public function detail_simpanan(Request $request)
    {
        $nasabah = Nasabah::all();

        $id_nasabah = $request->id_nasabah;
        $startDate = $request->from;
        $endDate = $request->to;

        $past = [];

        
        if ($startDate && $endDate) {
        $past = new RiwayatTabungan;
        $past = $past->where('id_nasabah', $id_nasabah);
        $past = $past->whereDate('created_at', '<', $startDate);
        $past = $past->get();
        }


        $models = new RiwayatTabungan;

        if($id_nasabah){
            $models = $models->where('id_nasabah', $id_nasabah);
        }

        if ($startDate && $endDate) {
        $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } 

        $models = $models->get();

        return view($this->index_detail, compact('models', 'nasabah', 'past' ,'startDate', 'endDate', 'id_nasabah'));
    }

    public function simpanan_export(Request $request)
    {

        $id_nasabah = $request->id_nasabah;
        $startDate = $request->from;
        $endDate = $request->to;

        $past = [];

        
        if ($startDate && $endDate) {
        $past = new RiwayatTabungan;
        $past = $past->where('id_nasabah', $id_nasabah);
        $past = $past->whereDate('created_at', '<', $startDate);
        $past = $past->get();
        }


        $item = new RiwayatTabungan;

        if($id_nasabah){
            $item = $item->where('id_nasabah', $id_nasabah);
        }

        if ($startDate && $endDate) {
        $item = $item->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } 

        $item = $item->get();

        return Excel::download(new SimpananExport($past, $item), 'report_simpanan_'.date('d_m_Y_H_i_s').'.xlsx');
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
