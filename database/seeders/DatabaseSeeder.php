<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(AdminUserSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(GajiSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(HariSeeder::class);
    }
}
