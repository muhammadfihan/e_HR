<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ams.com',
            'password' => bcrypt('admin123'),
            'nama_perusahaan' => 'PT AMS Indonesia',
            'jumlah_karyawan' => '1000',
            'jabatan' => 'SuperAdmin',
            'status' => 'Diterima',
            'role' => 'Manager',
            'provinsi' => 'Jawa Tengah',
            'kota' => 'Surakarta',
            'det_alamat' => 'Sekolah Vokasi Universitas Sebelas Maret, Surakarta, Jawa Tengah',
            'kode_pos' => '12345',
            'npwp' => '123456789',
            'bidang' => 'HR Management',
        ]);
    }
}
