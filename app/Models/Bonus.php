<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "bonus";
    protected $fillable = [
        'email_admin',
        'jenis_bonus',
        'nominal',
    ];
    protected $dates = ['deleted_at'];
}
