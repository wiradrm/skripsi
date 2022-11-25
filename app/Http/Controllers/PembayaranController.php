<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use App\Nasabah;
use App\Pinjam;
use App\Tabungan;
use App\Hutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PembayaranController extends Controller
{
    protected $page = 'admin.pembayaran.';
    protected $index = 'admin.pembayaran.index';
    protected $updated = 'admin.pembayaran.updated';

    public function index(Request $request)
    {
        $models = Hutang::all();

        $datas = DB::table('nasabah')
                        ->join('pembayaran', 'pembayaran.id_nasabah', '=', 'nasabah.id')
                        ->get();

        return view($this->index, compact('models' , 'datas'));
    }

    function edit($id){
        $model = new Hutang();

        $hutang = $model->find($id);

        return view($this->updated, compact('hutang'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_nasabah'                    => 'required',
                'jumlah'                 => 'required|integer',

            ],
            [
                'required'          => ':attribute is required.'
            ],
            [
                'id_nasabah'                    => 'Nasabah',
                'jumlah'                 => 'Setoran',
            ]
        );

        $check = $request->hutang * $request->persen / 100;
        if ($check) {
            if ($request->jumlah < $check) {
                return redirect()->route('pembayaran')->with('msg', 'Minimal membayar bunga!');
            }
        } else {
            return redirect()->route('pembayaran')->with('msg', 'Minimal membayar bunga!');
        }

        DB::transaction(function () use ($request) {
            // Insert into deposit

            $bunga = $request->hutang * $request->persen / 100;

            $model = new Pembayaran();
            $model->no_pinjam = $request->no_pinjam;
            $model->id_nasabah = $request->id_nasabah;
            $model->jumlah = $request->jumlah;
            $model->pokok = $request->jumlah - $bunga;
            $model->bunga = $bunga;
            $model->persen = $request->persen;
            $model->save();

            // Reduce savings balance
            $saving = Hutang::where('no_pinjam', $request->no_pinjam)->first();
            $saving->hutang = ($request->hutang - $model->pokok);
            $saving->save();

        });




        return redirect()->back()->with('info', 'Berhasil menambah data pembayaran');
    }

    public function destroy($id)
    {
        $model = Simpan::findOrFail($id);

        $balance_check = Tabungan::where('id_nasabah', $model->id_nasabah)->first();
        if ($balance_check) {
            if ($model->jumlah > $balance_check->saldo) {
                return redirect()->route('simpan')->with('msg', 'Tidak bisa menghapus data simpanan karna menyebabkan saldo minus! Cek kembali!');
            }
        } else {
            return redirect()->route('simpan')->with('msg', 'Tidak bisa menghapus data simpanan karna menyebabkan saldo minus! Cek kembali!');
        }

        
        $id_nasabah = $model->id_nasabah;
        
        $balance = Tabungan::where('id_nasabah', $id_nasabah)->first();
        $balance->saldo = ($balance->saldo - $model->jumlah);
        $balance->save();
        
        DB::table('simpan')->where('id',$id)->delete();
        
        DB::table('riwayat_tabungan')->where('id_simpan', $model->id)->delete();
                
        return redirect()->route('simpan')->with('info', 'Berhasil menghapus data');
    }

}
