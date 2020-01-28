<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReportSellingAddNumberAndCustomerName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_sellings', function (Blueprint $table) {
            $table->string('number')->default(null);
            $table->string('customer_name')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_sellings', function (Blueprint $table) {
            $table->dropColumn('number');
            $table->dropColumn('customer_name');
        });
    }
}
