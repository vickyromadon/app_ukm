<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInvoicesModifyOnSomeField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            \DB::statement("ALTER TABLE invoices MODIFY status ENUM('payment', 'approve', 'reject', 'pending', 'cancel', 'shipment', 'done')");
            $table->bigInteger('subtotal')->default(0)->nullable();
            $table->bigInteger('shipping')->default(0)->nullable();
            $table->string('reason')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            \DB::statement("ALTER TABLE invoices MODIFY status ENUM('payment', 'approve', 'reject', 'pending', 'cancel')");
            $table->dropColumn('subtotal');
            $table->dropColumn('shipping');
            $table->dropColumn('reason');

        });
    }
}
