<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'nama_perusahaan' => 'PT AMS Indonesia',
                'jumlah_karyawan' => '50',
                'jabatan' => 'CEO',
                'role' => 'Admin',
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Surakarta',
                'det_alamat' => 'Sekolah Vokasi Universitas Sebelas Maret, Surakarta, Jawa Tengah',
                'kode_pos' => '12345',
                'npwp' => '123456789',
                'bidang' => 'IT',
            ],
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('admin123'),
                'nama_perusahaan' => 'PT AMS',
                'jumlah_karyawan' => '50',
                'jabatan' => 'CEO',
                'role' => 'Manager',
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Surakarta',
                'det_alamat' => 'Sekolah Vokasi Universitas Sebelas Maret, Surakarta, Jawa Tengah',
                'kode_pos' => '12345',
                'npwp' => '123456789',
                'bidang' => 'IT',
            ]
        );
    }
}
