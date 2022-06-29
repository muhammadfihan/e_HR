<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = "datagaji";

    protected $fillable = [
        'name',
        'id',
        'nama_lengkap',
        'id_admin',
        'email',
        'tanggal',
        'no_pegawai',
        'id_jabatan',
        'id_golongan',
        'jam_kerja',
        'status',
        'id_tunjangan',
        'id_bonus',
        'id_potongan',
        'nominal_tunjangan',
        'nominal_bonus',
        'nominal_potongan'
    ];

}
