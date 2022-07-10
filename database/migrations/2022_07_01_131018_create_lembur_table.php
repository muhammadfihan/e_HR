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
        Schema::create('lembur', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id_admin')->on('akunpegawai');
            $table->string('email');
            $table->date('tanggal_lembur');
            $table->string('nama_lengkap');
            $table->string('no_pegawai');
            $table->time('jammulai');
            $table->time('jamselesai');
            $table->text('aktifitas');
            $table->string('buktilembur');
            $table->enum('status_lembur', ['Diterima', 'Ditolak','Diproses'])->default('Diproses');
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
        Schema::dropIfExists('lembur');
    }
};
