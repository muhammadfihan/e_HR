<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPegawai extends Model
{
    use HasFactory;
    protected $table = "pegawais";

    protected $fillable = [
        'name',
        'id',
        'nama_lengkap',
        'id_admin',
        'email',
        'no_pegawai',
        'id_golongan',
        'pendidikan',
        'id_jabatan',
        'jam_kerja',
        'jumlah_kerja',
        'tanggal_masuk',
        'no_ktp',
        'no_hp',
        'gender',
        'alamat',
    ];

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
}
