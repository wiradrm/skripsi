<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hargas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->integer('id_toko_gudang');
            $table->integer('id_jenis_telur');
            $table->integer('harga_jual_per_tray');
            $table->integer('harga_gudang_per_tray');
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
        Schema::dropIfExists('hargas');
    }
}
