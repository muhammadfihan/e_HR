<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamAbsen extends Model
{
    use HasFactory;
    protected $table = "jamabsen";

    protected $fillable = [
        'id_admin',
        'jam_masuk',
        'jam_pulang',
    ];
}
