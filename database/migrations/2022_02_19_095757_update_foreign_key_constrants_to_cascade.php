<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyConstrantsToCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_uuid')) {
                $table->dropForeign('products_category_uuid_foreign');
                $table->foreign('category_uuid')->references('uuid')->on('categories')->onDelete('cascade');
            };  
        });

        Schema::table('jwt_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('jwt_tokens', 'user_id')) {
                $table->dropForeign('jwt_tokens_user_id_foreign');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            };  
        });
        
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'user_id')) {
               $table->dropForeign('orders_user_id_foreign');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            };  
        });
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_status_id')) {
                $table->dropForeign('orders_order_status_id_foreign');
                $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            };  
        });
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_id')) {
                $table->dropForeign('orders_payment_id_foreign');
                $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            };  
        });

    }
}
