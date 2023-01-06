<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
   
    protected $table = "pengumuman";
    protected $fillable = [
       'id_admin',
       'judul',
       'isi',
       'tanggal_pengumuman',
       'tanggal_dibuat'
    ];
}
