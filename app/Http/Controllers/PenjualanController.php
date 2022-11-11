<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\JenisTelur;
use App\Penjualan;
use App\TokoGudang;
use App\Harga;
use App\Hutang;
use App\TelurMasuk;
use App\TelurKeluar;
use App\TransferStock;
use App\Helper\StockHelper;
use App\Helper\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use App\Helper\HutangHelpers;
use Illuminate\Support\Carbon;
use App\Exports\PenjualanExport;
use App\Helper\StockKandangHelper;
use App\Notification;
use App\TelurKandang;
use App\TransferStockKandang;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Http\RedirectResponse;

class PenjualanController extends Controller
{
    protected $page = 'admin.penjualan.';
    protected $index = 'admin.penjualan.index';

    public function index(Request $request)
    {
        $jenistelur = JenisTelur::all();
        $startDate = $request->from;
        $endDate = $request->to;
        $statusPembayaran = $request->status_pembayaran;
        $models = Penjualan::latest('created_at');
        $customer = Customer::latest('created_at')->where('status', '!=', 0)->get();

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }
        if ($statusPembayaran) {
            $models = $models->where('status_pembayaran', $statusPembayaran);
        }
        if (Auth::user()->level != 2) {
            $models = $models->where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest('created_at')->get();
        } else {
            $models = $models->latest('created_at')->get();
        }
        if (Auth::user()->id == 1) {
            $tokogudang = TokoGudang::all();
        } else {
            $tokogudang = TokoGudang::where('id', Auth::user()->id_toko_gudang)->get();
        }

        $setharga = Harga::where('id_toko_gudang', Auth::user()->id_toko_gudang)->latest()->get()->unique('id_jenis_telur');
        $harga = $setharga;

        return view('admin.penjualan.index', compact('models', 'jenistelur', 'tokogudang', 'harga', 'customer'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'status_pembayaran'           => 'required',


            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'status_pembayaran'           => 'Pembayaran',
            ]
        );

        if (Auth::user()->level != 2) {
            $id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $id_toko_gudang = $request->id_toko_gudang;
        }

        if ($request->satuan == "Tray") {
            $jumlah = $request->jumlah * 30;
            $subtotal = $request->jumlah * $request->harga;
        } else {
            $jumlah = $request->jumlah;
            $subtotal = $request->harga;
        }

        if ($request->type == 1) {
            $id_toko_tujuan = $request->id_toko_tujuan;
            $customer = TokoGudang::where('id', $request->id_toko_tujuan)->pluck('nama')->first();
        } else {
            $id_toko_tujuan = 0;
            if ($request->status_pembayaran == 2) {
                $customer = Customer::where('id', $request->id_customer)->pluck('name')->first();
            } else {
                $customer = $request->customer;
            }
        }

        $stockin = TelurMasuk::where('id_toko_gudang', $id_toko_gudang)->where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $id_toko_gudang)->where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stocktoko = $stockin - $stockout;

        $stockinkandang = TelurKandang::where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stockkandang = $stockinkandang - $stockout;

        if ($stocktoko >= $jumlah || $stockkandang >= $jumlah) {
            $model = new Penjualan();
            $model->id_user = Auth::user()->id;
            $model->id_toko_gudang = $id_toko_gudang;
            $model->harga = $request->harga;
            $model->subtotal = $subtotal;
            $model->status_pembayaran = $request->status_pembayaran;
            if ($model->status_pembayaran == 2) {
                $model->paid = $request->pembayaran_awal;
                $model->customer = $customer;
                $model->id_customer = $request->id_customer;
            } else {
                $model->customer = $customer;
                $model->id_customer = 0;
                $model->paid = $request->paid;
            }
            $model->change = $model->paid - $model->subtotal;
            if (!$request->created_at) {
                $model->created_at = Carbon::now();
            } else {
                $model->created_at = $request->created_at;
            }
            $model->save();

            $telurKandang = TelurKandang::where('id_jenis_telur', $request->id_jenis_telur)->first();
            if ($telurKandang) {
                $stockKandangHelper = StockKandangHelper::transfers(0, 0, $jumlah, $request->id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $request->satuan, $model->id);
                if ($stockKandangHelper && $id_toko_tujuan !== 0) {
                    $createNotification = NotificationHelper::createNotification(1, $stockKandangHelper->getData()->stock->id_toko_tujuan, $stockKandangHelper->getData()->stock->id, "Telur Masuk", 1);
                }
                $checkError = $stockKandangHelper->getData()->error;
                if ($stockKandangHelper && !$checkError) {
                    $model->id_telur_keluar = $stockKandangHelper->getData()->stock->id;
                    $model->save();
                } else {
                    $model->delete();
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah data!');
                }
            } else {
                $stockHelper = StockHelper::transfers($jumlah, $request->id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $request->satuan, $model->id, $request->created_at);
                if ($stockHelper && $id_toko_tujuan !== 0) {
                    $createNotification = NotificationHelper::createNotification(1, $stockHelper->getData()->stock->id_toko_tujuan, $stockHelper->getData()->stock->id, "Telur Masuk", 1);
                }
                $checkError = $stockHelper->getData()->error;
                if ($stockHelper && !$checkError) {
                    $model->id_telur_keluar = $stockHelper->getData()->stock->id;
                    $model->save();
                } else {
                    $model->delete();
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah data!');
                }
            }

            if ($model->id_telur_keluar !== 0) {
                if ($request->status_pembayaran == 2) {
                    $createHutang = HutangHelpers::createHutang($id_toko_gudang, $model->id, 2, $model->subtotal, $request->pembayaran_awal, $request->tgl_pelunasan, $request->id_customer);
                }
            }
            return redirect()->back()->with('info', 'Berhasil menambah data');
        } else {
            return redirect()->back()->with('error', 'Stock tidak mencukupi');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_jenis_telur'              => 'required',
                'satuan'                      => 'required',
                'jumlah'                      => 'required',
                'status_pembayaran'           => 'required',
            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_jenis_telur'              => 'Jenis Telur',
                'satuan'                      => 'Satuan',
                'jumlah'                      => 'Jumlah',
                'status_pembayaran'           => 'Pembayaran',
            ]
        );
        if (Auth::user()->level != 2) {
            $id_toko_gudang = Auth::user()->id_toko_gudang;
        } else {
            $id_toko_gudang = $request->id_toko_gudang;
        }

        if ($request->satuan == "Tray") {
            $jumlah = $request->jumlah * 30;
            $subtotal = $request->jumlah * $request->harga;
        } else {
            $jumlah = $request->jumlah;
            $subtotal = $request->harga;
        }

        if ($request->type == 1) {
            $id_toko_tujuan = $request->id_toko_tujuan;
            $customer = TokoGudang::where('id', $request->id_toko_tujuan)->pluck('nama')->first();
        } else {
            $id_toko_tujuan = 0;
            if ($request->status_pembayaran == 2) {
                $customer = Customer::where('id', $request->id_customer)->pluck('name')->first();
            } else {
                $customer = $request->customer;
            }
        }

        $stockin = TelurMasuk::where('id_toko_gudang', $id_toko_gudang)->where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stockout = TelurKeluar::where('id_toko_gudang', $id_toko_gudang)->where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stocktoko = $stockin - $stockout;
        $stockinkandang = TelurKandang::where('id_jenis_telur', $request->id_jenis_telur)->sum('jumlah');
        $stockkandang = $stockinkandang - $stockout;

        $model = Penjualan::findOrFail($id);
        $id_telur_keluar = TelurKeluar::where('id_penjualan', $id)->pluck('id')->first();
        $transfer = TransferStock::where('id_telur_keluar', $id_telur_keluar)->get();
        $transfer_kandang = TransferStockKandang::where('id_penjualan', $id)->get();
        $stock = TelurKeluar::where('id_penjualan', $id)->get();
        $notification = Notification::where('type', 1)->where('id_transaction', $id_telur_keluar)->get();

        if ($stocktoko >= $jumlah || $stockkandang >= $jumlah) {
            $jenistelur = JenisTelur::find($request->id_jenis_telur);
            $activestock = TelurMasuk::where('id_jenis_telur', $request->id_jenis_telur)->first();
            if ($activestock) {
                $jenistelur->id_stock_active = $activestock->id;
                $jenistelur->save();
            }

            $model->id_user = Auth::user()->id;
            if (Auth::user()->level != 2) {
                $model->id_toko_gudang = Auth::user()->id_toko_gudang;
            } else {
                $model->id_toko_gudang = $request->id_toko_gudang;
            }
            $model->customer = $customer;
            $model->harga = $request->harga;
            $model->subtotal = $subtotal;
            $model->status_pembayaran = $request->status_pembayaran;
            if ($model->status_pembayaran == 2) {
                $model->paid = $request->pembayaran_awal;
                $model->customer = $customer;
                $model->id_customer = $request->id_customer;
            } else {
                $model->customer = $customer;
                $model->id_customer = 0;
                $model->paid = $request->paid;
            }
            $model->change = $model->paid - $model->subtotal;
            if (!$request->created_at) {
                $model->created_at = Carbon::now();
            } else {
                $model->created_at = $request->created_at;
            }
            session(['tempPenjualan' => $model]);
            $tempModel = session('tempPenjualan');

            $telurKandang = TelurKandang::where('id_jenis_telur', $request->id_jenis_telur)->first();
            if ($telurKandang) {
                $stockKandangHelper = StockKandangHelper::transfers(0, 0, $jumlah, $request->id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $request->satuan, $tempModel->id);
                if ($stockKandangHelper && $id_toko_tujuan !== 0) {
                    $createNotification = NotificationHelper::createNotification(1, $stockKandangHelper->getData()->stock->id_toko_tujuan, $stockKandangHelper->getData()->stock->id, "Telur Masuk", 1);
                }
                $checkError = $stockKandangHelper->getData()->error;
                if ($stockKandangHelper && !$checkError) {
                    $model->id_telur_keluar = $stockKandangHelper->getData()->stock->id;
                    $model->save();
                    session()->forget('tempPenjualan');
                } else {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data!');
                }
            } else {
                $stockHelper = StockHelper::transfers($jumlah, $request->id_jenis_telur, $id_toko_gudang, $id_toko_tujuan, $request->satuan, $tempModel->id, $request->created_at);
                if ($stockHelper && $id_toko_tujuan !== 0) {
                    $createNotification = NotificationHelper::createNotification(1, $stockHelper->getData()->stock->id_toko_tujuan, $stockHelper->getData()->stock->id, "Telur Masuk", 1);
                }
                $checkError = $stockHelper->getData()->error;
                if ($stockHelper && !$checkError) {
                    $model->id_telur_keluar = $stockHelper->getData()->stock->id;
                    $model->save();
                    session()->forget('tempPenjualan');
                } else {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data!');
                }
            }

            if ($transfer || $transfer_kandang || $notification || $stock) {
                foreach ($transfer as $key => $value) {
                    $value->delete();
                }

                foreach ($transfer_kandang as $key => $value) {
                    $value->delete();
                }

                foreach ($stock as $key => $value) {
                    $value->delete();
                }

                foreach ($notification as $key => $value) {
                    $value->delete();
                }
            }

            if ($request->status_pembayaran == 2) {
                $hutang = Hutang::where('type_transaction', 2)->where('id_transaction', $id)->first();
                if (!$hutang) {
                    $createHutang = HutangHelpers::createHutang($id_toko_gudang, $model->id, 2, $model->subtotal, $request->pembayaran_awal, $request->tgl_pelunasan, $request->id_customer);
                } else {
                    $updateHutang = HutangHelpers::updateHutang($id, $id_toko_gudang, $model->id, 2, $model->subtotal, $request->pembayaran_awal, $request->tgl_pelunasan, $request->id_customer);
                }
            } else {
                $hutang = Hutang::where('type_transaction', 2)->where('id_transaction', $id)->first();
                if ($hutang) {
                    $hutang->delete();
                }
            }

            return redirect()->back()->with('info', 'Berhasil mengubah data');
        } else {
            return redirect()->back()->with('error', 'Stock tidak mencukupi');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $stock = TelurKeluar::where('id_penjualan', $id)->first();
        if ($stock) {
            $transfer = TransferStock::where('id_telur_keluar', $stock->id)->get();
            $transfer_kandang = TransferStockKandang::where('id_penjualan', $id)->get();
            $notification = Notification::where('type', 1)->where('id_transaction', $stock->id)->get();
            if ($transfer || $transfer_kandang) {
                foreach ($transfer as $key => $value) {
                    $value->delete();
                }

                foreach ($transfer_kandang as $key => $value) {
                    $value->delete();
                }

                foreach ($notification as $key => $value) {
                    $value->delete();
                }
            }
            $stock->delete();


            $jenistelur = JenisTelur::find($stock->id_jenis_telur);
            $getActive = TelurMasuk::where('id_jenis_telur', $jenistelur->id)->where('id_toko_gudang', Auth::user()->id_toko_gudang)->orderBy('id', 'desc')->get();
            foreach ($getActive as $key => $item) {
                $checkActive = TransferStock::where('id_telur_masuk', $item->id)->sum('jumlah');
                $jumlahActive =  $item->jumlah - $checkActive;
                if ($jumlahActive > 0) {
                    $active = $item->id;
                }
            }
            if ($active == null) {
                $jenistelur->id_stock_active = 0;
            } else {
                $jenistelur->id_stock_active = $active;
            }
            $jenistelur->save();
        }


        $hutang = Hutang::where('type_transaction', 2)->where('id_transaction', $id)->first();
        if ($hutang) {
            $hutang->delete();
        }

        $notif = Notification::where('type', 2)->where('id_transaction', $id)->first();
        if ($notif) {
            $notif->delete();
        }

        $model = Penjualan::find($id);
        $model->delete();

        return redirect()->back()->with('info', 'Berhasil menghapus data');
    }

    public function export(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        $toko = $request->id_toko_gudang;

        $item = Penjualan::orderby('created_at', 'DESC')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('id_toko_gudang', $toko)
            ->get();

        return Excel::download(new PenjualanExport($item), 'report_penjualan' . date('d_m_Y_H_i_s') . '.xlsx');
    }
}
