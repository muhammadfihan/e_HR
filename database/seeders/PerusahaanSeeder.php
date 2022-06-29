<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { Perusahaan::create([
        'admin_perusahaan' => 'Admin',
        'email_perusahaan' => 'admin@gmail.com',
        'nama_perusahaan' => 'PT AMS Indonesia',
        'jumlah_karyawan' => '50',
        'provinsi' => 'Jawa Tengah',
        'kota' => 'Surakarta',
        'det_alamat' => 'Sekolah Vokasi Universitas Sebelas Maret, Surakarta, Jawa Tengah',
        'kode_pos' => '12345',
        'npwp' => '123456789',
        'bidang' => 'IT',
    ]);
        
    }
}
