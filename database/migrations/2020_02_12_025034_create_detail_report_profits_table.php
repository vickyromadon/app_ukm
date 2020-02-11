<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailReportProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_report_profits', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('report_profit_id');
            $table->foreign('report_profit_id')->references('id')->on('report_profits')->onDelete('cascade');

            $table->string('type');
            $table->string('transaction_number');
            $table->date('transaction_date');

            $table->integer('quantity_in');
            $table->bigInteger('cogs_in');

            $table->integer('quantity_out');
            $table->bigInteger('cogs_out');

            $table->integer('quantity_avg');
            $table->bigInteger('cogs_avg');

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
        Schema::dropIfExists('detail_report_profits');
    }
}
