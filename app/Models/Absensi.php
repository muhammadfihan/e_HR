<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absensipegawai";

    protected $fillable = [
        'name',
        'id',
        'id_admin',
        'name',
        'email',
        'nama_lengkap',
        'foto_selfie',
        'tanggal',
        'lokasi',
        'jam_masuk',
        'jam_pulang',
        'jam_kerja',
        'keterangan'
    ];
}
