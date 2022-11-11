<?php

use Illuminate\Database\Seeder;
use App\Harga;

class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new Harga([
            "id_user"              => 1,
            "id_toko_gudang"       => 1,
            "id_jenis_telur"       => 1,
            "harga_jual_per_tray"      => 33000,
            "harga_gudang_per_tray"    => 30000,
        ]);
        $item1->save();

        $item2 = new Harga([
            "id_user"              => 1,
            "id_toko_gudang"       => 1,
            "id_jenis_telur"       => 2,
            "harga_jual_per_tray"      => 35000,
            "harga_gudang_per_tray"    => 32000,
        ]);
        $item2->save();

        $item3 = new Harga([
            "id_user"              => 1,
            "id_toko_gudang"       => 1,
            "id_jenis_telur"       => 3,
            "harga_jual_per_tray"      => 25000,
            "harga_gudang_per_tray"    => 20000,
        ]);
        $item3->save();
    }
}
