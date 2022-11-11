<?php

use App\JenisKandang;
use Illuminate\Database\Seeder;

class JenisKandangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new JenisKandang([
            "id_user"              => 1,
            "jenis_kandang"        => "Kandang 1",
        ]);
        $item1->save();
    }
}
