<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqAbsen extends Model
{
    use HasFactory;
    protected $table = "reqabsen";
    protected $fillable = [
        'id_admin',
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
