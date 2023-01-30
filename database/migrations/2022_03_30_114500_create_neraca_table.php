<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeracaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neraca', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('perkiraan')->nullable();
            $table->string('sandi')->nullable();
            $table->string('jumlah')->nullable();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('neraca');
    }
}
