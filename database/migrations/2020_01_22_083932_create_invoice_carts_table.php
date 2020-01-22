<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_carts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

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
        Schema::dropIfExists('invoice_carts');
    }
}
