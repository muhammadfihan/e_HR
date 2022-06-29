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
        Schema::create('datagaji', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('id_admin');
            $table->string('no_pegawai');
            $table->string('name');
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->unique();
            $table->integer('id_golongan')->unsigned()->nullable();
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->integer('id_tunjangan')->unsigned()->nullable();
            $table->foreign('id_tunjangan')->references('id')->on('tunjangan');
            $table->integer('id_bonus')->unsigned()->nullable();
            $table->foreign('id_bonus')->references('id')->on('bonus');
            $table->integer('id_potongan')->unsigned()->nullable();
            $table->foreign('id_potongan')->references('id')->on('potongan');
            $table->integer('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan');
            $table->bigInteger('nominal_tunjangan')->nullable();
            $table->bigInteger('nominal_bonus')->nullable();
            $table->bigInteger('nominal_potongan')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_kerja')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
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
        Schema::dropIfExists('datagaji');
    }
};
