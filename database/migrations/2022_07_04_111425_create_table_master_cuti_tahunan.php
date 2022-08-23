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
        Schema::create('table_master_cuti_tahunan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id_admin')->on('akunpegawai');
            $table->string('email');
            $table->string('no_pegawai');
            $table->string('nama_lengkap');
            $table->integer('id_cuti')->unsigned();
            $table->foreign('id_cuti')->references('id')->on('master_cuti_perusahaan');
            $table->integer('jumlah_cuti');
            $table->integer('cuti_terpakai');
            $table->integer('sisa_cuti');
            $table->string('tahun');
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
        Schema::dropIfExists('table_master_cuti_tahunan');
    }
};
