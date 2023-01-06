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
        Schema::create('job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin');
            $table->string('email_pegawai');
            $table->string('judul_job');
            $table->longText('deskripsi');
            $table->string('status')->default('In Progress');
            $table->string('pengumpulan')->nullable();
            $table->string('nilai')->nullable();
            $table->date('deadline');
            $table->date('terkumpul')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('revisi')->nullable();
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
        Schema::dropIfExists('job');
    }
};
