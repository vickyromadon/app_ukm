<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDetailAssembliesAddPriceAndTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_assemblies', function (Blueprint $table) {
            $table->bigInteger('price')->default(0);
            $table->bigInteger('total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_assemblies', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('total');
        });
    }
}
