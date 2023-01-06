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
        Schema::create('lokasipegawai', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin');
            $table->integer('id_pegawai');
            $table->string('email');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('lokasipegawai');
    }
};
