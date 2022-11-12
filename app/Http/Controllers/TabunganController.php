<?php

namespace App\Http\Controllers;

use App\Customer;
use App\TokoGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected $page = 'admin.customer.';
    protected $index = 'admin.customer.index';

    public function index(Request $request)
    {
        $models = Customer::where('id_toko_gudang', Auth::user()->id_toko_gudang)->get();
        return view($this->index, compact('models'));
    }

    public function store(Request $request)
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

        $model = new Customer();
        $model->id_toko_gudang = Auth::user()->id_toko_gudang;
        $model->name = $request->name;
        $model->alamat = $request->alamat;
        $model->no_telpon = $request->no_telpon;
        $model->save();

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
