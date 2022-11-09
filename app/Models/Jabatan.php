<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "jabatan";
    
  
    protected $fillable = [
        'id_admin',
        'jabatan',
        'gaji',

    ];
    protected $dates = ['deleted_at'];
}
