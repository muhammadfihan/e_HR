<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqAbsen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "reqabsen";
    protected $fillable = [
        'id_admin',
        'uid',
        'id',
        'name',
        'email',
        'nama_lengkap',
        'no_pegawai',
        'tanggal_req',
        'alasan',
        'bukti_pendukung',
        'status_req'
    ];
}
