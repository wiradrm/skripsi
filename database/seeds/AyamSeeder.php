<?php

use Illuminate\Database\Seeder;
use App\Ayam;

class AyamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new Ayam([
            "id_jenis_kandang"      => 1,
            "jumlah"                => 1000,
        ]);
        $item1->save();
    }
}
