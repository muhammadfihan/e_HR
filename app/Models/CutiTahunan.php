<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiTahunan extends Model
{
    use HasFactory;

    protected $table = "table_master_cuti_tahunan";
    protected $fillable = [
        'id',
        'id_admin',
        'id_cuti',
        'email',
        'jumlah_cuti',
        'cuti_terpakai',
        'sisa_cuti',
        'tahun',
        
    ];
}
