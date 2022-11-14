<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_pinjam')->unique();
            $table->unsignedBigInteger('id_nasabah');
            $table->date('tanggal');
            $table->bigInteger('pinjaman');
            $table->float('bunga');
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
        Schema::dropIfExists('pinjam');
    }
}
