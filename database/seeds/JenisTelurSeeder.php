<?php

use Illuminate\Database\Seeder;
use App\JenisTelur;

class JenisTelurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new JenisTelur([
            "jenis_telur"        => "Telur Kecil",
            "id_stock_active"    => 0,
        ]);
        $item1->save();

        $item2 = new JenisTelur([
            "jenis_telur"        => "Telur Besar",
            "id_stock_active"    => 0,
        ]);
        $item2->save();

        $item3 = new JenisTelur([
            "jenis_telur"        => "Telur Campur",
            "id_stock_active"    => 0,
        ]);
        $item3->save();
    }
}
