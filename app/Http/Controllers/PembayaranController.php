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

    public function index(Request $request)
    {
        $models = DB::table('pinjam')
                        ->join('nasabah', 'pinjam.id_nasabah', '=', 'nasabah.id')
                        ->join('hutang', 'pinjam.id_nasabah', '=', 'hutang.id_nasabah')
                        ->get();

        return view($this->index, compact('models'));
    }

    public function update(Request $request, $id)
    {
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

            // Insert into deposit
            $model = Simpan::findOrFail($id);

            $history_jumlah = $model->jumlah;
            
            $balance = Tabungan::where('id_nasabah', $model->id_nasabah)->first();
            $balance->saldo = ($balance->saldo - $history_jumlah);
            
            $balance->save();



            if ($model->id_nasabah == $request->id_nasabah) {
                $balance_history = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance_history->saldo = ($balance_history->saldo + $request->jumlah);
                $balance_history->save();

                $saving_history = RiwayatTabungan::where('id_simpan', $model->id)->first();
                $saving_history->id_nasabah = $request->id_nasabah;
                $saving_history->tanggal = $request->tanggal;
                $saving_history->kredit = $request->jumlah;
                $saving_history->save();
            } 
            
            
            if ($model->id_nasabah != $request->id_nasabah) {
                
                
                $balance_other = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance_other->saldo = ($balance_other->saldo + $request->jumlah);
                $balance_other->save();


                $saving_history = RiwayatTabungan::where('id_simpan', $model->id)->first();
                $saving_history->id_nasabah = $request->id_nasabah;
                $saving_history->tanggal = $request->tanggal;
                $saving_history->kredit = $request->jumlah;
                $saving_history->save();

            }

            $model->id_nasabah = $request->id_nasabah;
            $model->tanggal = $request->tanggal;
            $model->jumlah = $request->jumlah;
            $model->save();






        return redirect()->back()->with('info', 'Berhasil mengubah data');
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
