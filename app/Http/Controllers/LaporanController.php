<?php

namespace App\Http\Controllers;
use App\Harga;
use App\TelurMasuk;
use App\TelurKeluar;
use App\JenisTelur;
use App\TokoGudang;
use App\Penjualan;
use App\Pembelian;
use App\Pengeluaran;
use App\Hutang;
use App\JenisKandang;
use App\TelurKandang;
use App\TransferStockKandang;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    protected $page = 'admin.laporan.';
    protected $harga = 'admin.laporan.harga';
    protected $stock = 'admin.laporan.stock';
    protected $stock_kandang = 'admin.laporan.stock_kandang';
    protected $stock_in = 'admin.laporan.stock_in';
    protected $stock_out = 'admin.laporan.stock_out';
    protected $penjualan = 'admin.laporan.penjualan';
    protected $pembelian = 'admin.laporan.pembelian';
    protected $pengeluaran = 'admin.laporan.pengeluaran';
    protected $hutang = 'admin.laporan.hutang';
    protected $labarugi = 'admin.laporan.labarugi';
    protected $efektivitas = 'admin.laporan.efektivitas';

    public function index_harga(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $jenis_telur = $request->id_jenis_telur;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $jenistelur = JenisTelur::latest('created_at');
        $models = Harga::latest('created_at');
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if ($jenis_telur) {
            $jenistelur = JenisTelur::where('id',$jenis_telur);
            $models = $models->where('id_jenis_telur', $jenis_telur);
        }
        if(Auth::user()->level === 0){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
        }
        $models = $models->get();
        $jenistelur = $jenistelur->get();

        $color[] = ['rgba(235, 77, 75, 1)','rgba(42, 77, 255, 1)', 'rgba(0, 208, 23, 1)', 'rgba(220, 217, 7, 1)', 'rgba(7, 175, 220, 1)'];

        $ChartItem = array();
        $a = 0;
        foreach($jenistelur as $key => $telur){
            $dates = collect();
            if ($startDate && $endDate) {
                $period = CarbonPeriod::create($startDate, $endDate);
                foreach ($period as $item) {
                    $date = $item->format('Y-m-d');
                    if($toko){
                        $chart = Harga::whereDate('created_at', $item)->where('id_toko_gudang', $toko)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                        $latest = Harga::whereDate('created_at', '<', $item)->where('id_toko_gudang', $toko)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                    } else {
                        $chart = Harga::whereDate('created_at', $item)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                        $latest = Harga::whereDate('created_at', '<', $item)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                    }

                    if($chart){
                        $dates->put( $date, $chart->harga_jual_per_tray);
                    } else {
                        $dates->put( $date, $latest->harga_jual_per_tray ?? 0);
                    }
                }
            } else {
                foreach( range( -6, 0 ) AS $i ) {
                    $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                    if($toko){
                        $chart = Harga::whereDate('created_at', $date)->where('id_toko_gudang', $toko)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                        $latest = Harga::whereDate('created_at', '<', $date)->where('id_toko_gudang', $toko)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                    } else {
                        $chart = Harga::whereDate('created_at', $date)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                        $latest = Harga::whereDate('created_at', '<', $date)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                    }
                    if($chart){
                        $dates->put( $date, $chart->harga_jual_per_tray);
                    } else {
                        $dates->put( $date, $latest->harga_jual_per_tray ?? 0);
                    }
                }
            }

            $chart = $dates;
            $ChartItem[] = ['data' => $chart, 'jenis' => $telur->jenis_telur, 'color' => $color[0][$a]];
            $a++;
        }
        return view($this->harga, compact('models', 'jenistelur', 'tokogudang', 'ChartItem'));
    }

    public function index_stock(Request $request)
    {
        $jenisTelur = $request->id_jenis_telur;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $jenistelur = JenisTelur::all();

        $models = new TelurMasuk;
        $stockKandang = new TelurKandang;

        if ($jenisTelur) {
            $models = $models->where('id_jenis_telur', $jenisTelur);
            $stockKandang = $stockKandang->where('id_jenis_telur', $jenisTelur);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
            $stockKandang = $stockKandang->where('id_toko_gudang', $toko);
        }
        if (Auth::user()->level == 0) {
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $stockKandang = $stockKandang->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }

        $models = $models->groupBy('id_jenis_telur')->get();
        $telurKandang = $stockKandang->groupBy('id_jenis_telur')->get();
        
        $models = $models->toBase()->merge($telurKandang);

        return view($this->stock, compact('models', 'tokogudang', 'jenistelur'));
    }

    public function efektivitas_bertelur(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        
        $models = new TelurKandang;

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $models = $models->get();
        return view($this->efektivitas, compact('models'));
    }

    public function index_stock_kandang(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $jenistelur = JenisTelur::all();
        $models = new TelurKandang;
        $stockOut = new TransferStockKandang;

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $stockOut = $stockOut->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
            $stockOut = $stockOut->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }

        $models = $models->get();
        $stockOut = $stockOut->get()->sum('jumlah');
        $count = $models->sum('jumlah') - $stockOut;

        return view($this->stock_kandang, compact('models', 'jenistelur', 'tokogudang', 'count'));
    }

    public function index_stock_in(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $jenistelur = JenisTelur::all();
        $models = TelurMasuk::where('id_pembelian', '==', 0)->latest('created_at');

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();
        $count = $models->sum('jumlah');

        return view($this->stock_in, compact('models', 'jenistelur', 'tokogudang', 'count'));
    }

    public function index_stock_out(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $tokogudang = TokoGudang::all();
        $jenistelur = JenisTelur::all();
        
        $models = TelurKeluar::where('id_penjualan', '==', 0)->latest('created_at');

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();
        $count = $models->sum('jumlah');

        return view($this->stock_out, compact('models', 'jenistelur', 'tokogudang', 'count'));
    }

    public function index_penjualan(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $models = Penjualan::latest('created_at');

        $countStockOut = new TelurKeluar();
        $countPenjualan = new Penjualan();

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $countStockOut = $countStockOut->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $countPenjualan = $countPenjualan->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
            $countStockOut = $countStockOut->where('id_toko_gudang', $toko);
            $countPenjualan = $countPenjualan->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $countStockOut = $countStockOut->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPenjualan = $countPenjualan->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $countStockOut = $countStockOut->where('id_penjualan', '!=', 0)->sum('jumlah');
        $countPenjualan = $countPenjualan->sum('subtotal');
        
        $models = $models->get();
        
        $ChartPenjualan = array();
        
        $color[] = ['rgba(235, 77, 75, 1)','rgba(42, 77, 255, 1)', 'rgba(0, 208, 23, 1)', 'rgba(220, 217, 7, 1)', 'rgba(7, 175, 220, 1)'];
        $b = 0;
        foreach($tokogudang as $key => $toko){
            $dates = collect();
            if ($startDate && $endDate) {
                $period = CarbonPeriod::create($startDate, $endDate);
                foreach ($period as $item) {
                    $date = $item->format('Y-m-d');
                    if(Auth::user()->level != 2){
                        $penjualan = Penjualan::whereDate('created_at', $date)->where('id_toko_gudang',  Auth::user()->id_toko_gudang)->latest('created_at')->first();
                    } else {
                        $penjualan = Penjualan::whereDate('created_at', $date)->where('id_toko_gudang', $toko->id)->latest('created_at')->first();
                    }
                    if($penjualan){
                        $dates->put( $date, $penjualan->sum('subtotal'));
                    } else {
                        $dates->put( $date, 0);
                    }
                }
            } else {
                foreach( range( -6, 0 ) AS $i ) {
                    $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                    $penjualan = Penjualan::whereDate('created_at', $date)->where('id_toko_gudang', $toko->id)->latest('created_at')->first();
                    if($penjualan){
                        $dates->put( $date, $penjualan->sum('subtotal'));
                    } else {
                        $dates->put( $date, 0);
                    }
                }
            }

            $DataPenjualan = $dates;
            $ChartPenjualan[] = ['data' => $DataPenjualan, 'nama' => $toko->nama, 'color' => $color[0][$b]];
            $b++;
        }

        return view($this->penjualan, compact('models', 'tokogudang', 'ChartPenjualan','countStockOut','countPenjualan'));
    }

    public function index_pembelian(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $models = Pembelian::latest('created_at');

        $countStockIn = new TelurMasuk();
        $countPembelian = new Pembelian();

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $countStockIn = $countStockIn->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $countPembelian = $countPembelian->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
            $countStockIn = $countStockIn->where('id_toko_gudang', $toko);
            $countPembelian = $countPembelian->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countStockIn = $countStockIn->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPembelian = $countPembelian->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();
        $countStockIn = $countStockIn->where('id_pembelian', '!=', 0)->sum('jumlah');
        $countPembelian = $countPembelian->sum('subtotal');

        return view($this->pembelian, compact('models', 'tokogudang', 'countStockIn', 'countPembelian'));
    }

    public function index_pengeluaran(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $tokogudang = TokoGudang::all();
        $models = Pengeluaran::latest('created_at');
        $countPengeluaran = new Pengeluaran();

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $countPengeluaran = $countPengeluaran->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
            $countPengeluaran = $countPengeluaran->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPengeluaran = $countPengeluaran->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();
        $countPengeluaran = $countPengeluaran->sum('subtotal');

        return view($this->pengeluaran, compact('models', 'tokogudang', 'countPengeluaran'));
    }

    public function index_hutang(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;
        $typeTransactions = $request->type_transaction;

        $tokogudang = TokoGudang::all();
        $models = Hutang::latest('created_at');

        if($typeTransactions){
            $models = $models->where('type_transaction', $typeTransactions);
        }
        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $models = $models->where('id_toko_gudang', $toko);
        }
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        $models = $models->get();

        return view($this->hutang, compact('models', 'tokogudang'));
    }

    public function index_labarugi(Request $request)
    {
        $tokogudang = TokoGudang::all();
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $penjualan = new Penjualan();
        if(Auth::user()->level != 2){
            $penjualan = $penjualan->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        if ($startDate && $endDate) {
            $penjualan = $penjualan->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $penjualan = $penjualan->where('id_toko_gudang', $toko);
        }
        $penjualan = $penjualan->get();
        $penjualanTotal = $penjualan->sum('subtotal');

        $pembelian = new Pembelian();
        if(Auth::user()->level != 2){
            $pembelian = $pembelian->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        if ($startDate && $endDate) {
            $pembelian = $pembelian->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $pembelian = $pembelian->where('id_toko_gudang', $toko);
        }
        $pembelian = $pembelian->get();
        $pembelianTotal = $pembelian->sum('subtotal');

        $pengeluaran = new Pengeluaran();
        if(Auth::user()->level != 2){
            $pengeluaran = $pengeluaran->where('id_toko_gudang', Auth::user()->id_toko_gudang);
        }
        if ($startDate && $endDate) {
            $pengeluaran = $pengeluaran->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($toko){
            $pengeluaran = $pengeluaran->where('id_toko_gudang', $toko);
        }
        $pengeluaran = $pengeluaran->get();
        $pengeluaranTotal = $pengeluaran->sum('subtotal');

        $labaKotor = $penjualanTotal - $pembelianTotal;
        $labaOperasi = $pengeluaranTotal;
        $labaBersih = $labaKotor - $labaOperasi;

        return view($this->labarugi, compact('tokogudang', 'labaKotor', 'labaOperasi', 'labaBersih', 'penjualan', 'penjualanTotal', 'pembelian', 'pembelianTotal', 'pengeluaran', 'pengeluaranTotal'));
    } 
}
