<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $table = "bonus";
    protected $fillable = [
        'email_admin',
        'jenis_bonus',
        'nominal',
    ];
}
