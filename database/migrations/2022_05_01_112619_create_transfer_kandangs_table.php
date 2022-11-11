<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferKandangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_stock_kandangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_telur_kandang')->nullable();
            $table->integer('id_telur_masuk')->nullable();
            $table->integer('id_penjualan')->nullable();
            $table->integer('jumlah');
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
        Schema::dropIfExists('transfer_stock_kandangs');
    }
}
