<?php

namespace App\Exports;

use DB;
use App\Tabungan;
use App\Pinjam;
use App\Hutang;
use App\Nasabah;
use App\Pemasukan;
use App\Pengeluaran;
use App\Surat;
use App\RiwayatTabungan;
use App\Pembayaran;
use App\Laba;
use App\Neraca;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LabaExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $view = 'admin.laporan.export.laba';
    protected $endDate;
    protected $totalPemasukan;
    protected $totalPengeluaran;
    protected $pendapatanAdmin;
    protected $pendapatanBunga;
    protected $labaBersih;
    protected $labaKotor;
    protected $labaOperasi;
    protected $startDate;


    function __construct ($totalPemasukan, $totalPengeluaran, $pendapatanBunga, $pendapatanAdmin, $labaKotor, $labaBersih, $labaOperasi , $startDate, $endDate) {
      $this->totalPemasukan = $totalPemasukan;
      $this->totalPengeluaran = $totalPengeluaran;
      $this->pendapatanBunga = $pendapatanBunga;
      $this->pendapatanAdmin = $pendapatanAdmin;
      $this->labaKotor = $labaKotor;
      $this->labaOperasi = $labaOperasi;
      $this->labaBersih = $labaBersih;
      $this->startDate = $startDate;
      $this->endDate = $endDate;
    }

    public function view(): View
    {
        $bunga = new Pembayaran();
        $bunga = $bunga->get();
        $pendapatanBunga = $bunga->sum('bunga');

        $administrasi = new Pembayaran();

        $administrasi = $administrasi->get();
        $pendapatanAdmin = $administrasi->sum('administrasi');

        $pemasukan = new Pemasukan();
        $pemasukan = $pemasukan->get();
        $totalPemasukan = $pemasukan->sum('jumlah');

        $pengeluaran = new Pengeluaran();
        $pengeluaran = $pengeluaran->get();
        $totalPengeluaran = $pengeluaran->sum('jumlah');


        $labaKotor = $pendapatanBunga + $pendapatanAdmin + $totalPemasukan;
    
        
        $labaOperasi = $totalPengeluaran;
        $labaBersih = $labaKotor - $labaOperasi;
        
        $mytime =  date('d-m-Y');

        return view($this->view, [
            'endDate' => $this->endDate,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPemasukan' => $totalPemasukan,
            'startDate' => $this->startDate,
            'pendapatanBunga' => $pendapatanBunga,
            'pendapatanAdmin' => $pendapatanAdmin,
            'labaKotor' => $labaKotor,
            'labaBersih' => $labaBersih,
            'mytime' => $mytime,
            'labaOperasi' => $labaOperasi
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $all = 28;
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
                $event->sheet->getStyle('A1:C' . $total)->applyFromArray($styleArray);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }
}