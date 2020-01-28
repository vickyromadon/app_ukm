<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('transaction_number');

            $table->integer('quantity_in');
            $table->bigInteger('cogs_in');

            $table->integer('quantity_out');
            $table->bigInteger('cogs_out');

            $table->integer('quantity_avg');
            $table->bigInteger('cogs_avg');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('report_stocks');
    }
}
