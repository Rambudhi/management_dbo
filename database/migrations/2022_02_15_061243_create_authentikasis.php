<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthentikasis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentikasis', function (Blueprint $table) {
            $table->increments('id');
            $table->index('id_user');
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->char('access_type', 1);
            $table->string('ip_address', 100);
            $table->string('token', 500)->unique();
            $table->boolean('is_login')->default(1);
            $table->timestamp('date_time_login', $precision = 0);
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
        Schema::dropIfExists('authentikasis');
    }
}
