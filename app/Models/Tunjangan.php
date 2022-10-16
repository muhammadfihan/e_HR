<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunjangan extends Model
{
    use HasFactory;
    protected $table = "tunjangan";
    protected $fillable = [
        'email_admin',
        'jenis_tunjangan',
        'nominal',
    ];
}
