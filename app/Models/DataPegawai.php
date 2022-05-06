<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPegawai extends Model
{
    use HasFactory;
    protected $table = "pegawais";
    
    protected $fillable = [
        'name',
        'email',
        'no_pegawai',
        'jabatan',
        'no_ktp',
        'no_hp',
        'gender',
        'alamat',
    ];
}
