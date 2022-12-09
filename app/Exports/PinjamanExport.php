<?php

namespace App\Exports;
use DB;
use App\Pembayaran;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PinjamanExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $view = 'admin.laporan.export.pinjaman';
    protected $no_pinjam;
    protected $startDate;
    protected $endDate;
    protected $pinjaman;


    function __construct ($no_pinjam, $startDate, $endDate, $pinjaman) {
      $this->no_pinjam = $no_pinjam;
      $this->startDate = $startDate;
      $this->endDate = $endDate;
      $this->pinjaman = $pinjaman;
    }

    public function view(): View
    {

        $id = DB::table('pinjam')->where('no_pinjam', $this->no_pinjam)->value('id_nasabah');
        $nama = DB::table('nasabah')->where('id', $id)->value('nama');

            $past = new Pembayaran;
            $past = $past->where('no_pinjam', $this->no_pinjam);
            $past = $past->whereDate('created_at', '<', $this->startDate);
            $past = $past->get();
    
    
            $models = new Pembayaran;
    
            $models = $models->where('no_pinjam', $this->no_pinjam);
    
            $models = $models->whereDate('created_at', '>=', $this->startDate)->whereDate('created_at', '<=', $this->endDate);
    
            $models = $models->get();



        return view($this->view, [
            'models' => $models,
            'past' => $past,
            'nama' => $nama,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'pinjaman' => $this->pinjaman,
            'count' => count($models)
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $models = new Pembayaran;
    
                $models = $models->where('no_pinjam', $this->no_pinjam);
        
                $models = $models->whereDate('created_at', '>=', $this->startDate)->whereDate('created_at', '<=', $this->endDate);
        
                $models = $models->get();

                $all = count($models);
                $total = $all + 4;
                $event->sheet->getDelegate()->getStyle('A1:J' . $total)->getFont()->setSize(12);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '#000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];      
                $event->sheet->getStyle('A1:G' . $total)->applyFromArray($styleArray);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }
}