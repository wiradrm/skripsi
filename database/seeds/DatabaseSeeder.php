<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(JenisTelurSeeder::class);
        $this->call(TokoGudangSeeder::class);
        $this->call(HargaSeeder::class);
        $this->call(JenisKandangSeeder::class);
        $this->call(AyamSeeder::class);
        $this->call(TelurKandangSeeder::class);
    }
}
