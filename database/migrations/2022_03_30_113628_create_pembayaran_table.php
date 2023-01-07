<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_pinjam');
            $table->unsignedBigInteger('id_nasabah');
            $table->bigInteger('jumlah');
            $table->bigInteger('administrasi');     
            $table->bigInteger('denda');     
            $table->bigInteger('pokok');
            $table->bigInteger('bunga');
            $table->string('persen');
            
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
        Schema::dropIfExists('pembayaran');
    }
}
