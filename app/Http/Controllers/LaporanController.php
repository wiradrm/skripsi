<?php

namespace App\Http\Controllers;

use App\Tabungan;
use App\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    protected $page = 'admin.laporan.';
    protected $index = 'admin.laporan.simpanan';

    public function index_simpanan(Request $request)
    {
        $models = Tabungan::all();
        return view($this->index, compact('models'));
    }


}
