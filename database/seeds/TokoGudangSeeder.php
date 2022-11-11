<?php

use Illuminate\Database\Seeder;
use App\TokoGudang;

class TokoGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = new TokoGudang([
            "nama"              => "Gudang 1",
            "alamat"            => "Sukawati",
            "type"              => 2,
        ]);
        $item1->save();

        $item2 = new TokoGudang([
            "nama"              => "Toko 1",
            "alamat"            => "Sukawati",
            "type"              => 1,
        ]);
        $item2->save();
    }
}
