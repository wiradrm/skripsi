<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->integer('paid')->after('subtotal');
            $table->integer('change')->after('paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->integer('paid')->after('subtotal');
            $table->integer('change')->after('paid');
        });
    }
}
