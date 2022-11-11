<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarik', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_nasabah');
            $table->dateTime('tanggal');
            $table->bigInteger('jumlah')->nullable();
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id')->on('nasabah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarik');
    }
}
