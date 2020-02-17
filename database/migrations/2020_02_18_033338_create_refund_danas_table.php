<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_danas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('invoice_id')->default(null)->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->unsignedBigInteger('seller_id')->default(null)->nullable();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');

            $table->bigInteger('nominal');

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
        Schema::dropIfExists('refund_danas');
    }
}
