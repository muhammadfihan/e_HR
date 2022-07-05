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
        Schema::create('reqabsen', function (Blueprint $table) {
            $table->increments('uid');
            $table->integer('id');
            $table->integer('id_admin');
            $table->string('name');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_pegawai');
            $table->string('alasan');
            $table->string('bukti_pendukung')->nullable();
            $table->enum('status_req', ['Diproses', 'Diterima', 'Ditolak'])->default('Diproses');
            $table->date('tanggal_req');
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
        Schema::dropIfExists('reqabsen');
    }
};
