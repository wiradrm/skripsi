<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelurKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telur_keluars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->integer('id_jenis_telur');
            $table->integer('id_telur_kandang')->nullable();
            $table->integer('id_toko_gudang');
            $table->string('satuan');
            $table->integer('jumlah');
            $table->integer('id_penjualan')->default(0);
            $table->integer('id_toko_tujuan')->default(0);
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
        Schema::dropIfExists('telur_keluars');
    }
}
