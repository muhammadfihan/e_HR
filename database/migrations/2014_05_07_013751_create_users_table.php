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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('role', ['Manager', 'Admin', 'Pegawai'])->default('Admin');
            $table->string('jabatan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->longText('det_alamat')->nullable();
            $table->bigInteger('npwp')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('bidang')->nullable();
            $table->string('logo')->nullable();
            $table->string('gambar')->nullable();
            $table->string('status')->default('Pending');
            $table->string('moto')->nullable();
            $table->string('website_pt')->nullable();
            $table->integer('jumlah_karyawan')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
