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
        Schema::create('users_ujians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->unsignedBigInteger("pelajaran_id");
            $table->foreign('pelajaran_id')->references('id')->on('pelajarans'); 
            $table->unsignedBigInteger("kelas_id");
            $table->foreign('kelas_id')->references('id')->on('kelas'); 
            $table->unsignedBigInteger("start_timestamp")->default(0);
            $table->unsignedBigInteger("end_timestamp")->default(0);
            $table->tinyInteger("is_done")->default(0);
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
        Schema::dropIfExists('ujians');
    }
};
