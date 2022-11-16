<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatTabunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_tabungan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_nasabah');
            $table->unsignedBigInteger('id_simpan')->nullable();
            $table->unsignedBigInteger('id_tarik')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('debet')->nullable();
            $table->bigInteger('kredit')->nullable();
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
        Schema::dropIfExists('riwayat_tabungan');
    }
}
