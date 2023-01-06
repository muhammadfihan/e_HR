<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturShift extends Model
{
    use HasFactory;
    protected $table = "aturshift";

    protected $fillable = [
        'id_admin',
        'jenis_shift',
        'jam_masuk',
        'jam_pulang',
    ];
}
