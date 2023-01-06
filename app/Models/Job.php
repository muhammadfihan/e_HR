<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = "job";

    protected $fillable = [
        'id_admin',
        'email_pegawai',
        'judul_job',
        'deskripsi',
        'pengumpulan',
        'status',
        'nilai',
        'deadline',
        'terkumpul',
        'keterangan',
        'revisi'
    ];
}
