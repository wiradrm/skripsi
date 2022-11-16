<?php

namespace App\Http\Controllers;

use App\Tarik;
use App\Nasabah;
use App\Tabungan;
use App\RiwayatTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TarikController extends Controller
{
    protected $page = 'admin.tarik.';
    protected $index = 'admin.tarik.index';

    public function index(Request $request)
    {
        $models = Tarik::orderBy('id', 'DESC')->get();
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

        $balance_check = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
        if ($balance_check) {
            if ($request->jumlah > $balance_check->saldo) {
                return redirect()->route('tarik')->with('msg', 'Saldo tidak mencukupi !');
            }
        } else {
            return redirect()->route('tarik')->with('msg', 'Saldo tidak mencukupi !');
        }

        DB::transaction(function () use ($request) {
            // Insert into deposit
            $model = new Tarik();
            $model->id_nasabah = $request->id_nasabah;
            $model->tanggal = $request->tanggal;
            $model->jumlah = $request->jumlah;
            $model->save();

            // Reduce savings balance
            $saving = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
            $saving->saldo = ($saving->saldo - $request->jumlah);
            $saving->save();

            $saving_history = new RiwayatTabungan;
            $saving_history->id_nasabah = $request->id_nasabah;
            $saving_history->id_tarik = $model->id;
            $saving_history->tanggal = $request->tanggal;
            $saving_history->keterangan = 'Penarikan';
            $saving_history->debet = $request->jumlah;
            $saving_history->save();


        });

        return redirect()->back()->with('info', 'Berhasil menambah data penarikan');
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

        $balance_check = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
        if ($balance_check) {
            if ($request->jumlah > $balance_check->saldo) {
                return redirect()->route('tarik')->with('msg', 'Saldo tidak mencukupi !');
            }
        } else {
            return redirect()->route('tarik')->with('msg', 'Saldo tidak mencukupi !');
        }
            // Insert into deposit
            
            $model = Tarik::findOrFail($id);

            $history_jumlah = $model->jumlah;
            
            $balance = Tabungan::where('id_nasabah', $model->id_nasabah)->first();
            $balance->saldo = ($balance->saldo + $history_jumlah);
            
            $balance->save();


            if ($model->id_nasabah == $request->id_nasabah) {
                $balance_history = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance_history->saldo = ($balance_history->saldo - $request->jumlah);
                $balance_history->save();

                $saving_history = RiwayatTabungan::where('id_tarik', $model->id)->first();
                $saving_history->id_nasabah = $request->id_nasabah;
                $saving_history->tanggal = $request->tanggal;
                $saving_history->keterangan = 'tarikan';
                $saving_history->debet = $request->jumlah;
                $saving_history->save();
            } 
            
            
            if ($model->id_nasabah != $request->id_nasabah) {
                
                
                $balance_other = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance_other->saldo = ($balance_other->saldo - $request->jumlah);
                
                $balance_other->save();


                $saving_history = RiwayatTabungan::where('id_tarik', $model->id)->first();
                $saving_history->id_nasabah = $request->id_nasabah;
                $saving_history->tanggal = $request->tanggal;
                $saving_history->keterangan = 'tarikan';
                $saving_history->debet = $request->jumlah;
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
        $model = Tarik::findOrFail($id);

        $id_nasabah = $model->id_nasabah;

        $balance = Tabungan::where('id_nasabah', $id_nasabah)->first();
        $balance->saldo = ($balance->saldo + $model->jumlah);
        $balance->save();
        
        DB::table('tarik')->where('id',$id)->delete();

        DB::table('riwayat_tabungan')->where('id_tarik', $model->id)->delete();
                
        return redirect()->route('tarik')->with('info', 'Berhasil menghapus data');
    }

}
