<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_status_id');
            $table->unsignedInteger('payment_id');
            $table->string('uuid', 255);
            $table->json('products');
            $table->json('address');
            $table->float('delivery_fee')->nullable();
            $table->float('amount')->unique(); //I don't know why your documentation says amount should be unique
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('restrict');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
