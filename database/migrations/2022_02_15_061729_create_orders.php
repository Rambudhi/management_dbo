<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
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
            $table->index('id_customer');
            $table->integer('id_customer')->unsigned()->nullable();
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->string('order_code', 100)->unique();
            $table->string('order_name', 40);
            $table->timestamp('order_date', $precision = 0);
            $table->integer('status');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->index('created_by');
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('created_at', $precision = 0);
            $table->index('updated_by');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamp('updated_at', $precision = 0)->nullable();
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
