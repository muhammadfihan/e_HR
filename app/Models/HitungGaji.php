<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HitungGaji extends Model
{
    use HasFactory;
    protected $table = "hitung_gaji";

    protected $fillable = [
        'no_gaji',
        'tunjangan',
        'bonus',
        'potongan',
        'nominal_tunjangan',
        'nominal_bonus',
        'nominal_potongan',
        'tanggal',
    ];
}
