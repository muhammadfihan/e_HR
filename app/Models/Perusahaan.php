<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = "perusahaan";
    protected $fillable = [
        'nama_perusahaan',
        'email_perusahaan',
        'id_admin',
        'admin_perusahaan',
        'provinsi',
        'kota',
        'npwp',
        'kode_pos',
        'det_alamat',
        'jumlah_karyawan',
        'bidang',
    ];
}
