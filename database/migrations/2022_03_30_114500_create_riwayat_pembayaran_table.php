<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_pinjam');
            $table->unsignedBigInteger('id_nasabah');
            $table->date('tanggal');
            $table->bigInteger('pokok');
            $table->bigInteger('bunga');
            $table->bigInteger('sisa');
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
        Schema::dropIfExists('riwayat_pembayaran');
    }
}
