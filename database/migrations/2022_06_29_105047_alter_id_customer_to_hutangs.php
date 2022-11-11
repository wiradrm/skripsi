<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIdCustomerToHutangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hutangs', function (Blueprint $table) {
            $table->integer('id_customer')->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hutangs', function (Blueprint $table) {
            $table->integer('id_customer')->after('id_user');
        });
    }
}
