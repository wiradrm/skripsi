<?php

namespace App\Http\Controllers;

use App\TelurKandang;
use Illuminate\Http\Request;

use App\Exports\EfektivitasExport;
use Maatwebsite\Excel\Facades\Excel;

class EfektivitasBertelurController extends Controller
{
    protected $page = 'admin.efektivitas_bertelur.';
    protected $index = 'admin.efektivitas_bertelur.index';

    public function index(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;
        
        $models = new TelurKandang;

        if ($startDate && $endDate) {
            $models = $models->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $models = $models->get();
        return view($this->index, compact('models'));
    }

    public function export(Request $request)
    {
        $startDate = $request->from;
        $endDate = $request->to;

        $item = TelurKandang::orderby('created_at', 'DESC')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        return Excel::download(new EfektivitasExport($item), 'report_efektivitas_bertelur_' . date('d_m_Y_H_i_s') . '.xlsx');
    }
}
