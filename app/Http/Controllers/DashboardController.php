<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\TelurMasuk;
use App\TelurKandang;
use App\Penjualan;
use App\TokoGudang;
use App\Harga;
use App\Pembelian;
use App\JenisTelur;
use App\Pengeluaran;

class DashboardController extends Controller
{   
    protected $page = 'admin.dashboard.';
    protected $index = 'admin.dashboard.index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {   
        $tokogudang = TokoGudang::all();
        $month = $request->month;
        $toko = $request->id_toko_gudang;

        if(Auth::user()->level == 2){
            $countStockIn = new TelurMasuk();
            $countStockKandang = new TelurKandang();
            $countPenjualan = new Penjualan();
            $countPengeluaran = new Pengeluaran();
            $countPembelian = new Pembelian();
            $stock = new TelurMasuk();
            $stockKandang = new TelurKandang();

            if($month){
                $countStockIn = $countStockIn->whereMonth('created_at', $month);
                $countStockKandang = $countStockKandang->whereMonth('created_at', $month);
                $countPenjualan = $countPenjualan->whereMonth('created_at', $month);
                $countPengeluaran = $countPengeluaran->whereMonth('created_at', $month);
                $countPembelian = $countPembelian->whereMonth('created_at', $month);
                $stock = $stock->whereMonth('created_at', $month)->groupBy('id_jenis_telur');
                $stockKandang = $stockKandang->whereMonth('created_at', $month);
            }
    
            if($toko){
                $countStockIn = $countStockIn->where('id_toko_gudang', $toko);
                $countStockKandang = $countStockKandang->where('id_toko_gudang', $toko);
                $countPenjualan = $countPenjualan->where('id_toko_gudang', $toko);
                $countPengeluaran = $countPengeluaran->where('id_toko_gudang', $toko);
                $countPembelian = $countPembelian->where('id_toko_gudang', $toko);
                $stock = $stock->where('id_toko_gudang', $toko)->groupBy('id_jenis_telur');
                $stockKandang = $stockKandang->where('id_toko_gudang', $toko);
            }

            $countStockIn = $countStockIn->where('id_pembelian', '==', 0)->count();
            $countStockKandang = $countStockKandang->count();
            $countPenjualan = $countPenjualan->sum('subtotal');
            $countPengeluaran = $countPengeluaran->sum('subtotal');
            $countPembelian = $countPembelian->sum('subtotal');

            $stock = $stock->groupBy('id_jenis_telur')->get();
            $stockKandang = $stockKandang->groupBy('id_jenis_telur')->get();
            
            $stock = $stock->toBase()->merge($stockKandang);

            $countSaldo = ($countPenjualan - $countPembelian) - $countPengeluaran;

        } else {
            $startDate = $request->from;
            $endDate = $request->to;

            $countStockIn = TelurMasuk::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countStockKandang = TelurKandang::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPenjualan = Penjualan::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPengeluaran = Pengeluaran::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $countPembelian = Pembelian::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $stock = TelurMasuk::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            $stockKandang = TelurKandang::where('id_toko_gudang', Auth::user()->id_toko_gudang);
            
            if ($startDate && $endDate) {
                $countStockIn = $countStockIn->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                $countStockKandang = $countStockKandang->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                $countPenjualan = $countPenjualan->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                $countPengeluaran = $countPengeluaran->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                $countPembelian = $countPembelian->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
                $stock = $stock->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->groupBy('id_jenis_telur');
                $stockKandang = $stockKandang->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            }

            $countStockIn = $countStockIn->where('id_pembelian', '==', 0)->count();
            $countStockKandang = $countStockKandang->count();
            $countPenjualan = $countPenjualan->sum('subtotal');
            $countPengeluaran = $countPengeluaran->sum('subtotal');
            $countPembelian = $countPembelian->sum('subtotal');
            $stock = $stock->groupBy('id_jenis_telur')->get();
            $stockKandang = $stockKandang->groupBy('id_jenis_telur')->get();

            $stock = $stock->toBase()->merge($stockKandang);

            $countSaldo = ($countPenjualan - $countPembelian) - $countPengeluaran;
        }

        $jenistelur = JenisTelur::all();
        $color[] = ['rgba(235, 77, 75, 1)','rgba(42, 77, 255, 1)', 'rgba(0, 208, 23, 1)', 'rgba(220, 217, 7, 1)', 'rgba(7, 175, 220, 1)'];
        $ChartItem = array();

        $a = 0;
        foreach($jenistelur as $key => $telur){
            $dates = collect();
            foreach( range( -6, 0 ) AS $i ) {
                $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                if(Auth::user()->level !== 2){
                    $chart = Harga::where('id_toko_gudang', Auth::user()->id_toko_gudang)->whereDate('created_at', $date)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                    $latest = Harga::where('id_toko_gudang', Auth::user()->id_toko_gudang)->whereDate('created_at', '<', $date)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                } else {
                    $findGudang = TokoGudang::where('type', 2)->pluck('id')->first();
                    $chart = Harga::where('id_toko_gudang', $findGudang)->whereDate('created_at', $date)->where('id_jenis_telur', $telur->id)->latest('created_at')->first();
                    $latest = Harga::where('id_toko_gudang', $findGudang)->whereDate('created_at', '<', $date)->latest('created_at')->where('id_jenis_telur', $telur->id)->first();
                }
                
                if($chart){
                    $dates->put( $date, $chart->harga_jual_per_tray);
                } else {
                    $dates->put( $date, $latest->harga_jual_per_tray ?? 0);
                }
            }

            $chart = $dates;
            $ChartItem[] = ['data' => $chart, 'jenis' => $telur->jenis_telur, 'color' => $color[0][$a]];
            $a++;
        }

        $ChartPenjualan = array();

        $b = 0;
        if(Auth::user()->level == 2){
            $tokogudang = TokoGudang::all();
        } else {
            $tokogudang = TokoGudang::where('id', Auth::user()->id_toko_gudang)->get();
        }
        foreach($tokogudang as $key => $toko){
            $dates = collect();
            foreach( range( -6, 0 ) AS $i ) {
                $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                $penjualan = Penjualan::whereDate('created_at', $date)->where('id_toko_gudang', $toko->id)->latest('created_at')->get();
                if($penjualan){
                    $dates->put( $date, $penjualan->sum('subtotal'));
                } else {
                    $dates->put( $date, 0);
                }
            }

            $DataPenjualan = $dates;
            $ChartPenjualan[] = ['data' => $DataPenjualan, 'nama' => $toko->nama, 'color' => $color[0][$b]];
            $b++;
        }

        return view($this->index, compact('tokogudang', 'stock', 'countPengeluaran', 'countPembelian', 'countSaldo', 'countStockIn', 'countStockKandang', 'countPenjualan', 'ChartItem', 'ChartPenjualan'));
    }
}
