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
            $table->bigIncrements('id');
            $table->string('no_pegawai');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->bigInteger('no_ktp');
            $table->bigInteger('no_hp');
            $table->longText('alamat');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            // $table->string('status')->default('Aktif');
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
