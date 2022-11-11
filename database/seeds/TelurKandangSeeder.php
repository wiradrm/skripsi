<?php

use Illuminate\Database\Seeder;
use App\TelurKandang;

class TelurKandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new TelurKandang([
            "id"                    => 1000,
            "id_user"               => 1,
            "id_jenis_telur"        => 3,
            "id_toko_gudang"        => 1,
            "satuan"                => "Tray",
            "jumlah"                => 300,
            "kedaluwarsa"           => '2022-06-01 00:00:00',
            "id_jenis_kandang"      => 1,
        ]);
        $item1->save();
    }
}
