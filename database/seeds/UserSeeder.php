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
            "username"          => "wulan",
            "level"             => 1,
            "password"          => bcrypt('wulan1234'),
        ]);
        $user1->save();

        $user2 = new User([
            "username"          => "wira",
            "level"             => 2,
            "password"          => bcrypt('wira1234'),
        ]);
        $user2->save();
    }
}
