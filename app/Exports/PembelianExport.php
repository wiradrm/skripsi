<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PembelianExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $view = 'admin.laporan.export.pembelian';
    protected $item;


    function __construct ($item) {
      $this->item = $item;
    }

    public function view(): View
    {
        return view($this->view, [
            'models' => $this->item,
            'count' => count($this->item)
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $all = count($this->item);
                $total = $all + 1;
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
                $event->sheet->getStyle('A1:J' . $total)->applyFromArray($styleArray);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }
}