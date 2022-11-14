<?php

namespace App\Http\Controllers;

use App\Simpan;
use App\Nasabah;
use App\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SimpanController extends Controller
{
    protected $page = 'admin.simpan.';
    protected $index = 'admin.simpan.index';

    public function index(Request $request)
    {
        $models = Simpan::orderBy('id', 'DESC')->get();
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

        });

        return redirect()->back()->with('info', 'Berhasil menambah data');
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
            } 
            
            
            if ($model->id_nasabah != $request->id_nasabah) {
                
                
                $balance_other = Tabungan::where('id_nasabah', $request->id_nasabah)->first();
                $balance_other->saldo = ($balance_other->saldo + $request->jumlah);
                
                $balance_other->save();

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

        $id_nasabah = $model->id_nasabah;

        $balance = Tabungan::where('id_nasabah', $id_nasabah)->first();
        $balance->saldo = ($balance->saldo - $model->jumlah);
        $balance->save();
        
        DB::table('simpan')->where('id',$id)->delete();
        
                
        return redirect()->route('simpan')->with('info', 'Berhasil menghapus data');
    }

}
