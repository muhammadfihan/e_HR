<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = "izin";
    public $timestamps = false;
    protected $fillable = [
        'id_admin',
        'id',
        'name',
        'nama_lengkap',
        'no_pegawai',
        'email',
        'status_izin',
        'tanggal',
        'jenis_izin',
        'bukti',
    ];
}
