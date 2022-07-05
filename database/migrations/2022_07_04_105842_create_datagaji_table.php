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
            $table->integer('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan');
            $table->integer('id_golongan')->unsigned()->nullable();
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->string('id_tunjangan')->nullable();
            $table->string('id_bonus')->nullable();
            $table->string('id_potongan')->nullable();
            $table->integer('total_tunjangan')->nullable();
            $table->integer('total_bonus')->nullable();
            $table->integer('total_potongan')->nullable();
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
