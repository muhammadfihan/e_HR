<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = "cuti";
    protected $fillable = [
        'id',
        'id_pegawai',
        'id_admin',
        'name',
        'nama_lengkap',
        'no_pegawai',
        'jumlah_hari',
        'email',
        'tanggal_cuti',
        'tanggal_mulai',
        'tanggal_akhir',
        'list_tanggal',
        'jenis_cuti',
        'keterangan',
        'bukti_cuti',
    ];
}
