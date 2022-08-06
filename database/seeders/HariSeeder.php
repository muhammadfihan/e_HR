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
              'hari' => 'Sunday',
            ],
            [
                'id' => '2',
                'hari' => 'Monday',
            ],
            [
                'id' => '3',
                'hari' => 'Tuesday',
            ],
            [
                'id' => '4',
                'hari' => 'Wednesday',
            ],
            [
                'id' => '5',
                'hari' => 'Thursday',
            ],
            [
                'id' => '6',
                'hari' => 'Friday',
            ],
            [
                'id' => '7',
                'hari' => 'Saturday',
            ],

          ];

          Hari::insert($hari);

    }
}
