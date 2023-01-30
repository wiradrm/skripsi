<?php

namespace App\Imports;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use DB;
use App\Laba;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LabaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Laba([
            'perkiraan'             => $row[0],
            'sandi'             => $row[1],
            'jumlah'             => $row[2],
        ]);
    }
}
