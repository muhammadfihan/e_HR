<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\Potongan;
use App\Models\Tunjangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tunjangan::create([
            'email_admin' => 'admin@gmail.com',
            'jenis_tunjangan' => 'Tidak Ada Tunjangan',
            'nominal' => 0
        ]);
        Bonus::create([
            'email_admin' => 'admin@gmail.com',
            'jenis_bonus' => 'Tidak Ada Bonus',
            'nominal' => 0
        ]);
        Potongan::create([
            'email_admin' => 'admin@gmail.com',
            'jenis_potongan' => 'Tidak Ada Potongan',
            'nominal' => 0
        ]);
    }
}
