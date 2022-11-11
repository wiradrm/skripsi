<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelurKandangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telur_kandangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->integer('id_jenis_telur');
            $table->integer('id_toko_gudang');
            $table->string('satuan');
            $table->integer('jumlah');
            $table->dateTime('kedaluwarsa')->nullable();
            $table->integer('id_jenis_kandang');
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
        Schema::dropIfExists('telur_kandangs');
    }
}
