<?php

namespace Database\Seeders;

use App\Models\AkunPegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AkunPegawai::create([
            'name' => 'Fihan',
            'email' => 'fihan2as@gmail.com',
            'password' => bcrypt('fihan123'),
            'id_admin' => 2,
            'id_jabatan' => 1,
            'role' => 'Pegawai',
            'tanggal_masuk' => '2021-05-02',
            'jumlah_kerja' => 480,
            'status' => 'Aktif',
        ]);
    }
}
