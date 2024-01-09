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
        Schema::create('users_jawabans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals'); 
            $table->unsignedBigInteger('jawaban_id')->nullable();
            $table->foreign('jawaban_id')->references('id')->on('jawabans'); 
            $table->unsignedBigInteger('user_ujian_id');
            $table->foreign('user_ujian_id')->references('id')->on('users_ujians'); 
            $table->text('result')->nullable();

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
        Schema::dropIfExists('users_jawabans');
    }
};
