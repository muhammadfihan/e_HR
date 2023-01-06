<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = "useractivity";
    
    protected $fillable = [
       'id_admin',
       'id_pegawai',
       'name',
       'email',
       'jabatan',
       'status',
   ];
}
