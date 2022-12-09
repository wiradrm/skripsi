<?php

namespace App\Exports;

use DB;
use App\RiwayatTabungan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SimpananExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $view = 'admin.laporan.export.simpanan';
    protected $id_nasabah;
    protected $endDate;
    protected $startDate;


    function __construct ($id_nasabah, $startDate, $endDate) {
      $this->id_nasabah = $id_nasabah;
      $this->startDate = $startDate;
      $this->endDate = $endDate;
    }

    public function view(): View
    {
        $nama = DB::table('nasabah')->where('id', $this->id_nasabah)->value('nama');

        $past = new RiwayatTabungan;
        $past = $past->where('id_nasabah', $this->id_nasabah);
        $past = $past->whereDate('created_at', '<', $this->startDate);
        $past = $past->get();

        $models = new RiwayatTabungan;

        $models = $models->where('id_nasabah', $this->id_nasabah);
        $models = $models->whereDate('created_at', '>=', $this->startDate)->whereDate('created_at', '<=', $this->endDate);
         

        $models = $models->get();

        return view($this->view, [
            'models' => $models,
            'nama' => $nama,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'past' => $past,
            'count' => count($models)
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $models = new RiwayatTabungan;

                $models = $models->where('id_nasabah', $this->id_nasabah);
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