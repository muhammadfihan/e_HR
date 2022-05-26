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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('akunpegawai');
            $table->integer('id_perusahaan')->unsigned();
            $table->foreign('id_perusahaan')->references('id')->on('perusahaan');
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id')->on('users');
            $table->string('no_pegawai');
            $table->string('name');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->integer('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan');
            $table->bigInteger('no_ktp');
            $table->bigInteger('no_hp');
            $table->longText('alamat');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('gender',['Laki-Laki','Perempuan'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->date('logout_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
