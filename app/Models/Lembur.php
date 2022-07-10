<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = "lembur";
    protected $fillable = [
        'id_admin',
        'email',
        'tanggal_lembur',
        'nama_lengkap',
        'no_pegawai',
        'jammulai',
        'jamselesai',
        'aktifitas',
        'buktilembur'
    ];
}
