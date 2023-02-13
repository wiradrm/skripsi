<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Pinjam;
use App\Hutang;
use App\Nasabah;
use App\Pemasukan;
use App\Pengeluaran;
use App\Surat;
use App\RiwayatTabungan;
use App\Pembayaran;
use App\Laba;
use App\Neraca;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\NeracaImport;
use App\Imports\LabaImport;


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
    protected $persetujuan = 'admin.laporan.persetujuan.persetujuan';
    protected $print = 'admin.laporan.surat.print';
    protected $buktibayar = 'admin.laporan.bukti.buktibayar';
    protected $buktitarik = 'admin.laporan.bukti.buktitarik';
    protected $cetak = 'admin.laporan.persetujuan.print';
    protected $index_neraca = 'admin.laporan.neraca.index';
    protected $index_laba = 'admin.laporan.labarugi.index';
    protected $neraca = 'admin.laporan.neraca.neraca';
    protected $laba = 'admin.laporan.labarugi.laba';

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



    public function index_persetujuan()
    {
        $nasabah = nasabah::all();

        return view($this->persetujuan, compact('nasabah' ));
    }


    public function buktibayar(Request $request, $id)
    {

        $model = DB::table('pembayaran')->where('id', $id)->first();
        
        // $hutang = DB::table('pembayaran')->where('no_pinjam',$model->no_pinjam)->get();
        // $nasabah = DB::table('nasabah')->where('id_nasabah',$model->id_nasabah)->get();

        $data = (object)[];
        $data->jumlah = $model->jumlah;
        $data->administrasi = $model->administrasi;
        $data->pokok = $model->pokok;
        $data->tanggal = $model->created_at;
        $data->bunga = $model->bunga;
        // $input['mobile'] = substr(str_replace(" ","",$input['mobile']),1);
        // $request->replace($input);
        // $data = Surat::where('id', $id)->first();


        $pdf = PDF::loadview($this->buktibayar, ['data' => $data]);

        return $pdf->stream('cetak_bukti.pdf');
    }

    public function buktitarik(Request $request, $id)
    {

        $model = DB::table('tarik')->where('id', $id)->first();
        
        // $hutang = DB::table('pembayaran')->where('no_pinjam',$model->no_pinjam)->get();
        // $nasabah = DB::table('nasabah')->where('id_nasabah',$model->id_nasabah)->get();

        $data = (object)[];
        $data->jumlah = $model->jumlah;
        $data->tanggal = $model->created_at;
        // $input['mobile'] = substr(str_replace(" ","",$input['mobile']),1);
        // $request->replace($input);
        // $data = Surat::where('id', $id)->first();


        $pdf = PDF::loadview($this->buktitarik, ['data' => $data]);

        return $pdf->stream('cetak_bukti.pdf');
    }


    public function cetak(Request $request)
    {

        $data = (object)[];
        $data->nama = $request->nama;
        $data->jumlah = $request->jumlah;
        $data->tanggal = $request->tanggal;
        $data->periode = $request->periode;
        $data->lama = $request->lama;
        // $input['mobile'] = substr(str_replace(" ","",$input['mobile']),1);
        // $request->replace($input);
        // $data = Surat::where('id', $id)->first();


        $pdf = PDF::loadview($this->print, ['data' => $data]);

        return $pdf->stream('cetak_surat.pdf');
    }

    public function print(Request $request)
    {
        $data = (object)[];
        $data->nama = $request->nama;
        $data->jumlah = $request->jumlah;
        $data->no = $request->no;
        $data->tanggal = $request->tanggal;
        $data->bunga = $request->bunga;
        // $input['mobile'] = substr(str_replace(" ","",$input['mobile']),1);
        // $request->replace($input);
        // $data = Surat::where('id', $id)->first();


        $pdf = PDF::loadview($this->cetak, ['data' => $data]);

        return $pdf->stream('surat_persetujuan.pdf');

        
    }

    public function destroy($id)
    {
        $model = Surat::findOrFail($id);
        DB::table('surat')->where('id',$id)->delete();
  
        return redirect()->route('laporan.tunggakan')->with('info', 'Berhasil menghapus data');
    }

    public function index_neraca()
    {
        //tabungan wajib
        $tabungan = new Tabungan();
        $tabungan = $tabungan->get();
        $totalTabungan = $tabungan->sum('saldo');

        $pokok = new Pembayaran();
        $pokok = $pokok->get();
        $totalPokok = $pokok->sum('pokok');

        $pemasukan = new Pemasukan();
        $pemasukan = $pemasukan->get();
        $totalPemasukan = $pemasukan->sum('jumlah');

        $pengeluaran = new Pengeluaran();
        $pengeluaran = $pengeluaran->get();
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        $tabunganWajib = $totalTabungan + $totalPokok;

        //tabungan sukarela
        $sukarela = new Hutang();
        $sukarela = $sukarela->get();
        $totalHutang = $sukarela->sum('hutang');

        //
        $pinjaman = new Pinjam();
        $pinjaman = $pinjaman->get();
        $totalPinjaman = $pinjaman->sum('pinjaman');

        //laba
        $bunga = new Pembayaran();
        $bunga = $bunga->get();
        $pendapatanBunga = $bunga->sum('bunga');

        $administrasi = new Pembayaran();
        $administrasi = $administrasi->get();
        $pendapatanAdmin = $administrasi->sum('administrasi');


        $labaKotor = $pendapatanBunga + $pendapatanAdmin + $totalPemasukan;
        $labaOperasi = $totalPengeluaran;
        $labaBersih = $labaKotor - $labaOperasi;

        $totalAktiva = $totalTabungan + $totalPinjaman + $labaBersih;
        $totalPassiva = $totalHutang + $tabunganWajib + $labaBersih;

        $mytime = date('d-m-Y');
        return view($this->index_neraca, compact('mytime','tabunganWajib', 'totalTabungan' , 'totalPinjaman', 'totalHutang', 'labaBersih', 'totalAktiva', 'totalPassiva'));
    }

    public function index_laba(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $bunga = new Pembayaran();
        if ($startDate && $endDate) {
            $bunga = $bunga->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $bunga = $bunga->get();
        $pendapatanBunga = $bunga->sum('bunga');

        $administrasi = new Pembayaran();
        if ($startDate && $endDate) {
            $administrasi = $administrasi->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $administrasi = $administrasi->get();
        $pendapatanAdmin = $administrasi->sum('administrasi');

        $pemasukan = new Pemasukan();
        if ($startDate && $endDate) {
            $pemasukan = $pemasukan->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        $pemasukan = $pemasukan->get();
        $totalPemasukan = $pemasukan->sum('jumlah');

        $pengeluaran = new Pengeluaran();
        if ($startDate && $endDate) {
            $pengeluaran = $pengeluaran->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        $pengeluaran = $pengeluaran->get();
        $totalPengeluaran = $pengeluaran->sum('jumlah');


        $labaKotor = $pendapatanBunga + $pendapatanAdmin + $totalPemasukan;
        $labaOperasi = $totalPengeluaran;
        $labaBersih = $labaKotor - $labaOperasi;
        
        $mytime =  date('d-m-Y');

        return view($this->index_laba, compact('mytime', 'startDate', 'endDate', 'totalPemasukan', 'totalPengeluaran' ,'pendapatanBunga' , 'pendapatanAdmin', 'labaKotor', 'labaOperasi', 'labaBersih'));
    }

    public function laba(Request $request)
    {
        $laba = Laba::all();

        return view($this->laba, compact('laba'));
    }

    public function neraca(Request $request)
    {
        $neraca = Neraca::all();

        return view($this->neraca, compact('neraca'));
    }

    public function laba_import(Request $request) 
    {
        DB::table('laba')->delete();  
        Excel::import(new LabaImport, $request->file('file')->store('temp'));
        return back()->with('info', 'Berhasil Import Laporan Laba');
    }

    public function neraca_import(Request $request) 
    {
        DB::table('neraca')->delete();  
        Excel::import(new NeracaImport, $request->file('file')->store('temp'));
        return back()->with('info', 'Berhasil Import Laporan Neraca');
    }

}
