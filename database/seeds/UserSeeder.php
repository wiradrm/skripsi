<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User([
            "name"              => "Bagus Pramajaya",
            "id_toko_gudang"    => 1,
            "username"          => "bagus",
            "no_telpon"         => "+6281234567890",
            "level"             => 1,
            "password"          => bcrypt('bagus12345'),
        ]);
        $user1->save();

        $user2 = new User([
            "name"              => "Wira Dharma",
            "id_toko_gudang"    => 2,
            "username"          => "wira",
            "no_telpon"         => "+6281234567890",
            "level"             => 0,
            "password"          => bcrypt('wira12345'),
        ]);
        $user2->save();

        $user3 = new User([
            "name"              => "Risky",
            "id_toko_gudang"    => 0,
            "username"          => "risky",
            "no_telpon"         => "+6281234567890",
            "level"             => 2,
            "password"          => bcrypt('risky12345'),
        ]);
        $user3->save();
    }
}
