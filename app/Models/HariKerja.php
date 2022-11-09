<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariKerja extends Model
{
    use HasFactory;
    protected $table = "harikerja";

    protected $fillable = [
        'id_admin',
        'hari_kerja',
        'jam_masuk',
        'jam_pulang',
        'buka_presensi',
        'tutup_presensi'
    ];
}
