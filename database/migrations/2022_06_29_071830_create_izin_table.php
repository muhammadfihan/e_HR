<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin');
            $table->string('name');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_pegawai');
            $table->string('jenis_izin');
            $table->string('bukti');
            $table->enum('status_izin', ['Diproses', 'Diterima', 'Ditolak'])->default('Diproses');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('izin');
    }
};
