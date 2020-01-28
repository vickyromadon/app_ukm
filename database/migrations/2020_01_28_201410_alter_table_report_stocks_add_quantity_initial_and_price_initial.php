<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReportStocksAddQuantityInitialAndPriceInitial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_stocks', function (Blueprint $table) {
            $table->integer('quantity_initial');
            $table->bigInteger('price_initial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_stocks', function (Blueprint $table) {
            $table->dropColumn('quantity_initial');
            $table->dropColumn('price_initial');
        });
    }
}
