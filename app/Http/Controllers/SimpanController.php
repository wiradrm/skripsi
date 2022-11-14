<?php

namespace App\Http\Controllers;

use App\Simpan;
use App\Nasabah;
use App\Tabungan;
use App\RiwayatTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SimpanController extends Controller
{
    protected $page = 'admin.simpan.';
    protected $index = 'admin.simpan.index';

    public function index(Request $request)
    {
        $models = Simpan::all();
        $nasabah = Nasabah::all();
        return view($this->index, compact('models','nasabah'));
    }

    public function store(Request $request)
    {
        // $nasabah = Nasabah::all();

        $this->validate(
            $request,
            [
                'id_nasabah'                    => 'required',
                'tanggal'                   => 'required',
                'jumlah'                 => 'required|integer',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_nasabah'                    => 'Nasabah',
                'tanggal'                      => 'Tanggal',
                'jumlah'                 => 'Setoran',
            ]
        );

        DB::transaction(function () use ($request) {
            // Insert into deposit
            $model = new Simpan();
            $model->id_nasabah = $request->id_nasabah;
            $model->tanggal = $request->tanggal;
            $model->jumlah = $request->jumlah;
            $model->save();

            // Create or Update Saving
            $check_balance = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
            if ($check_balance) {
                $balance = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance->saldo = ($balance->saldo + $request->jumlah);
                $balance->save();
            } else {
                $balance = new Tabungan;
                $balance->id_nasabah = $request->id_nasabah;
                $balance->saldo = $request->jumlah;
                $balance->save();
            }

            // Insert into history saving
            $last_balance = Tabungan::where('id_nasabah', $request->id_nasabah)->first();

            $saving_history = new RiwayatTabungan;
            $saving_history->id_nasabah = $request->id_nasabah;
            $saving_history->tanggal = $request->tanggal;
            $saving_history->keterangan = 'setoran';
            $saving_history->kredit = $request->jumlah;
            $saving_history->saldo = $last_balance->saldo;
            $saving_history->save();

        });

        return redirect()->back()->with('info', 'Berhasil menambah data');
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name'                      => 'required',
                'alamat'                    => 'required',
                'no_telpon'                 => 'required',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'name'                      => 'Nama',
                'alamat'                    => 'Alamat',
                'no_telpon'                 => 'No Telpon',
            ]
        );

        $model = Customer::findOrFail($id);
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->name = $request->name;
        $model->alamat = $request->alamat;
        $model->no_telpon = $request->no_telpon;
        $model->save();

        return redirect()->back()->with('info', 'Berhasil mengubah data');
    }

    public function deactivate($id)
    {
        $model = Customer::findOrFail($id);
        $model->status = 0;
        $model->save();
        return redirect()->back()->with('info', 'Berhasil menonactifkan customer');
    }

    public function activate($id)
    {
        $model = Customer::findOrFail($id);
        $model->status = 1;
        $model->save();
        return redirect()->back()->with('info', 'Berhasil mengaktifkan customer');
    }
}
