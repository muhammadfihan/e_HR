<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tunjangan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "tunjangan";
    protected $fillable = [
        'email_admin',
        'jenis_tunjangan',
        'nominal',
    ];
    protected $dates = ['deleted_at'];
}
