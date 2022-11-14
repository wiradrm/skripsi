<?php

namespace App\Http\Controllers;

use App\Customer;
use App\TokoGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected $page = 'admin.mutasi.';
    protected $index = 'admin.mutasi.index';

    public function index(Request $request)
    {
        $models = Customer::where('id_toko_gudang', Auth::user()->id_toko_gudang)->get();
        return view($this->index, compact('models'));
    }
}
