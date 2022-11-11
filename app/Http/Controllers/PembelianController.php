<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisTelur;
use App\TelurMasuk;
use App\Pembelian;
use App\TokoGudang;
use App\Hutang;
use App\TransferStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Exports\PembelianExport;
use App\Notification;
use App\Helper\PembelianHelpers;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PembelianController extends Controller
{
    protected $page = 'admin.pembelian.';
    protected $index = 'admin.pembelian.index';

    public function index(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $statusPembayaran = $request->status_pembayaran;
        $models = Pembelian::latest('created_at');

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if($statusPembayaran){
            $models = $models->where('status_pembayaran', $statusPembayaran);
        }
        
        if(Auth::user()->level != 2){
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang)->get();
        } else {
            $models = $models->get();
        }

        $jenistelur = JenisTelur::all();
        if(Auth::user()->id == 1){
            $tokogudang = TokoGudang::all();
        } else {
            $tokogudang = TokoGudang::where('id', Auth::user()->id_toko_gudang)->get();
        }

        return view($this->index, compact('models', 'jenistelur', 'tokogudang'));
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'supplier'                    => 'required',
                'harga_beli'                  => 'required',
                'status_pembayaran'           => 'required',
                'kedaluwarsa'                  => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'supplier'                    => 'Supplier',
                'harga_beli'                  => 'Harga Beli',
                'status_pembayaran'           => 'Pembayaran',
                'kedaluwarsa'                  => 'kedaluwarsa',
            ]
        );
        $createPembelian = PembelianHelpers::createPembelian($request->id_toko_gudang, $request->harga_beli, $request->satuan, $request->jumlah, $request->status_pembayaran, $request->pembayaran_awal, $request->tgl_pelunasan, $request->supplier, $request->image, $request->created_at, $request->id_jenis_telur, $request->kedaluwarsa);

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'supplier'                    => 'required',
                'harga_beli'                  => 'required',
                'status_pembayaran'           => 'required',
                'kedaluwarsa'                  => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'supplier'                    => 'Supplier',
                'harga_beli'                  => 'Harga Beli',
                'status_pembayaran'           => 'Pembayaran',
                'kedaluwarsa'                  => 'kedaluwarsa',
            ]
        );
        if($request->image){
            $model = Pembelian::find($id);
            unlink("storage/image/nota/".$model->image);
        }
        $updatePembelian = PembelianHelpers::updatePembelian($id, $request->id_toko_gudang, $request->harga_beli, $request->satuan, $request->jumlah, $request->status_pembayaran, $request->pembayaran_awal, $request->tgl_pelunasan, $request->supplier, $request->image, $request->created_at, $request->id_jenis_telur, $request->kedaluwarsa);

        return redirect()->back()->with('info', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $hutang = Hutang::where('type_transaction', 1)->where('id_transaction', $id)->first();
        if($hutang){
            $hutang->delete();
        }

        $notif = Notification::where('type', 3)->where('id_transaction', $id)->first();
        if($notif){
            $notif->delete();
        }

        $telurmasuk = TelurMasuk::where('id_pembelian', $id)->first();
        $transfer = TransferStock::where('id_telur_masuk', $telurmasuk->id)->get();
        foreach ($transfer as $key => $value) {
            $value->delete();
            $stockout = TelurMasuk::where('id', $value->id_telur_keluar);
            $stockout->delete();
        }
        $telurmasuk->delete();


        $jenistelur = JenisTelur::find($telurmasuk->id_jenis_telur);
        $stock = TelurMasuk::where('id_jenis_telur', $telurmasuk->id_jenis_telur)->first();
        if($stock == null){
            $jenistelur->id_stock_active = 0;
        } else {
            $jenistelur->id_stock_active = $stock->id;
        }
        $jenistelur->save();

        $model = Pembelian::find($id);
        if($model->image){
            unlink("storage/image/nota/".$model->image);
        }
        $model->delete();

        return redirect()->back()->with('info', 'Berhasil menghapus data');
    }

    public function export(Request $request){
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $item = Pembelian::orderby('created_at', 'DESC')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->where('id_toko_gudang', $toko)
        ->get();

        return Excel::download(new PembelianExport($item), 'report_pembelian_'.date('d_m_Y_H_i_s').'.xlsx');
    }
}
