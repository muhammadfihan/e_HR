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
        Schema::create('cuti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pegawai');
            $table->string('name');
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id_admin')->on('akunpegawai');
            $table->string('email');
            $table->string('no_pegawai');
            $table->string('nama_lengkap');
            $table->integer('jumlah_hari');
            $table->date('tanggal_cuti');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->string('list_tanggal')->nullable();
            $table->string('jenis_cuti');
            $table->LongText('keterangan');
            $table->string('bukti_cuti');
            $table->enum('status_cuti', ['Diterima', 'Ditolak','Diproses'])->default('Diproses');
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
        Schema::dropIfExists('cuti');
    }
};
