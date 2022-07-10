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
        Schema::create('laporan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id_admin')->on('akunpegawai');
            $table->string('email');
            $table->string('no_pegawai');
            $table->string('nama_lengkap');
            $table->date('tanggal_laporan');
            $table->integer('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('akunpegawai');
            $table->LongText('deskripsi');
            $table->string('lampiran');
            $table->enum('status_laporan', ['Diterima', 'Ditolak','Diproses'])->default('Diproses');
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
        Schema::dropIfExists('laporan');
    }
};
