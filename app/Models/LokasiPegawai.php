<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPegawai extends Model
{
    use HasFactory;

    protected $table = "lokasipegawai";
    protected $fillable = [
       'id_admin',
       'id_pegawai',
       'email',
       'latitude',
       'longitude',
       'expired_at'
    ];
}
