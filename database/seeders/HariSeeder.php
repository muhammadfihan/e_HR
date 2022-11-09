<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hari;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hari =  [
            [
              'id' => '1',
              'hari' => 'Minggu',
            ],
            [
                'id' => '2',
                'hari' => 'Senin',
            ],
            [
                'id' => '3',
                'hari' => 'Selasa',
            ],
            [
                'id' => '4',
                'hari' => 'Rabu',
            ],
            [
                'id' => '5',
                'hari' => 'Kamis',
            ],
            [
                'id' => '6',
                'hari' => 'Jumat',
            ],
            [
                'id' => '7',
                'hari' => 'Sabtu',
            ],

          ];

          Hari::insert($hari);

    }
}
