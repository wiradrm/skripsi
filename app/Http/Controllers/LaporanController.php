<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Pinjam;
use App\Hutang;
use App\Nasabah;
use App\Surat;
use App\RiwayatTabungan;
use App\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

use App\Exports\SimpananExport;
use App\Exports\PinjamanExport;


class LaporanController extends Controller
{
    protected $page = 'admin.laporan.';
    protected $index = 'admin.laporan.simpan.simpanan';
    protected $index_detail = 'admin.laporan.simpan.detail';
    protected $pinjam = 'admin.laporan.pinjaman.pinjaman';
    protected $pinjam_detail = 'admin.laporan.pinjaman.detail';
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

        $nama = DB::table('nasabah')->where('id', $id_nasabah)->value('nama');

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

        return view($this->index_detail, compact('models', 'nasabah', 'past' ,'startDate', 'endDate', 'id_nasabah' ,'nama'));
    }

    public function simpanan_export(Request $request)
    {

        $id_nasabah = $request->id_nasabah;
        $startDate = $request->from;
        $endDate = $request->to;

        return Excel::download(new SimpananExport($id_nasabah, $startDate, $endDate), 'report_simpanan_'.date('d_m_Y_H_i_s').'.xlsx');
    }

    public function index_pinjaman(Request $request)
    {

        $pinjam = Pinjam::all();

        return view($this->pinjam, compact('pinjam'));
    }


    public function pinjam_detail(Request $request)
    {
        $pinjam = Pinjam::all();

        $no_pinjam = $request->no_pinjam;
        $startDate = $request->from;
        $endDate = $request->to;

        $id = DB::table('pinjam')->where('no_pinjam', $no_pinjam)->value('id_nasabah');
        $nama = DB::table('nasabah')->where('id', $id)->value('nama');


        $pinjaman = Pinjam::where('no_pinjam', $no_pinjam)->first();

        $past = [];

        
        if ($startDate && $endDate) {
        $past = new Pembayaran;
        $past = $past->where('no_pinjam', $no_pinjam);
        $past = $past->whereDate('created_at', '<', $startDate);
        $past = $past->get();
        }


        $models = new Pembayaran;

        if($no_pinjam){
            $models = $models->where('no_pinjam', $no_pinjam);
        }

        if ($startDate && $endDate) {
        $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } 

        $models = $models->get();

        return view($this->pinjam_detail, compact('models', 'pinjam', 'pinjaman', 'past' ,'startDate', 'endDate', 'no_pinjam', 'nama'));
    }

    public function pinjaman_export(Request $request)
    {

        $no_pinjam = $request->no_pinjam;
        $startDate = $request->from;
        $endDate = $request->to;

        $pinjaman = Pinjam::where('no_pinjam', $no_pinjam)->first();

        return Excel::download(new PinjamanExport($no_pinjam, $startDate, $endDate, $pinjaman), 'report_pinjaman_'.date('d_m_Y_H_i_s').'.xlsx');
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
