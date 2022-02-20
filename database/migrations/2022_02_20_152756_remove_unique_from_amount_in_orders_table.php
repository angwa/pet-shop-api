<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromAmountInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique('orders_amount_unique');
            $table->string('uuid')->unique()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('order_statuses', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('uuid')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
