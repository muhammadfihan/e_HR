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
            $table->integer('id');
            $table->integer('id_admin');
            $table->string('no_pegawai');
            $table->string('name');
            $table->string('nama_lengkap')->nullable();
            $table->string('email')->unique();
            $table->string('pendidikan')->nullable();
            $table->integer('id_golongan')->unsigned()->nullable();
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->integer('id_jabatan')->unsigned();
            $table->foreign('id_jabatan')->references('id')->on('jabatan');
            $table->time('jam_kerja')->nullable();
            $table->bigInteger('no_ktp')->nullable();
            $table->bigInteger('no_hp')->nullable();
            $table->longText('alamat')->nullable();
            $table->integer('jumlah_kerja')->nullable();
            $table->integer('jatah_cuti')->nullable();
            $table->date('tanggal_masuk');
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
