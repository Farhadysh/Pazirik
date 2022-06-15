<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('change_addresses');
            $table->bigInteger('shift_id')->unsigned()->nullable();
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->text('description')->nullable();
            $table->string('date');
            $table->tinyInteger('seen')->default(0);
            $table->timestamp('done')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->boolean('active')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('change_orders');
    }
}
