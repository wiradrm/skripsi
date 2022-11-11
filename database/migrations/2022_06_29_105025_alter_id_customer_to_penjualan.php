<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIdCustomerToPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->integer('id_customer')->after('customer');
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
            $table->integer('id_customer')->after('customer');
        });
    }
}
