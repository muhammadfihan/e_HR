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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_perusahaan');
            $table->string('jumlah_karyawan');
            $table->string('admin_perusahaan');
            $table->string('email_perusahaan')->unique();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->bigInteger('npwp')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->longText('det_alamat')->nullable();
            $table->string('bidang')->nullable();
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
        Schema::dropIfExists('perusahaan');
    }
};
