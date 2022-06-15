<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_factors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('factor_id');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('date');
            $table->integer('transport')->default(0)->nullable();
            $table->integer('discount')->default(0)->nullable();
            $table->integer('service')->default(0)->nullable();
            $table->integer('collecting')->default(0)->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('change_factors');
    }
}
