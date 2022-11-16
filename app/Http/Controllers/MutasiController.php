<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Nasabah;
use App\Simpan;
use App\Tarik;
use App\RiwayatTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    protected $page = 'admin.mutasi.';
    protected $index = 'admin.mutasi.index';
    
    public function index(Request $request)
    {
        $id = $request->id_nasabah;
        $models = new RiwayatTabungan;
        if ($id) {
            $models = $models->where('id_nasabah', $id);
        }
        $models = $models->groupBy('id_nasabah')->get();
        
        $saldo = 0;

        return view($this->index, compact('models' , 'saldo'));
    }

}
