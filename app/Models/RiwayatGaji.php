<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatGaji extends Model
{
    use HasFactory;
    protected $table = "riwayatgaji";
    protected $fillable = [
        'id_admin',
        'email',
        'tanggal_ambil',
        'id_jabatan',
        'id_golongan',
        'tunjangan',
        'nominal_tunjangan',
        'total_tunjangan',
        'bonus',
        'nominal_bonus',
        'total_bonus',
        'potongan',
        'nominal_potongan',
        'total_potongan',
        'gaji_kotor',
        'gaji_bersih',
        'gaji_pokok',
        'status'

    ];
}
