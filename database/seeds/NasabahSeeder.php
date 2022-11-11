<?php

use App\Nasabah;
use Illuminate\Database\Seeder;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new Nasabah([
            "id"                    => 101,
            "nama"                  => "I Made Wira Darma",
            "nik"                   => "517104260800012",
            "tanggal_lahir"         => "26-08-2000",
            "alamat"                => "Jl. Tunggul Ametung I Nomor 11",
            "telp"                  => "081239952314",
        ]);
        $item1->save();
    }
}
