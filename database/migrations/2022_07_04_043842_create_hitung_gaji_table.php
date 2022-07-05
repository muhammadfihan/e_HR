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
        Schema::create('hitung_gaji', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('id_admin');
            $table->string('no_gaji');
            $table->string('tunjangan')->nullable();
            $table->string('bonus')->nullable();
            $table->string('potongan')->nullable();
            $table->integer('nominal_tunjangan')->nullable();
            $table->integer('nominal_bonus')->nullable();
            $table->integer('nominal_potongan')->nullable();
            $table->date('tanggal')->nullable();
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
        Schema::dropIfExists('hitung_gaji');
    }
};
