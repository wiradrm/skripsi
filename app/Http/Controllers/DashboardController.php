<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Nasabah;
use App\Pinjam;
use App\Tabungan;

use App\User;
use DB;

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
        $countNasabah = Nasabah::count();
        $countPinjam = DB::table("pinjam")->get()->sum("pinjaman");
        $countTabungan = DB::table("tabungan")->get()->sum("saldo");

        return view($this->index, compact('countNasabah', 'countPinjam', 'countTabungan'));
    }
}
