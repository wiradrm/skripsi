<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_pinjam');
            $table->unsignedBigInteger('id_nasabah');
            $table->bigInteger('pinjaman');
            $table->integer('hutang');
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
        Schema::dropIfExists('hutang');
    }
}
