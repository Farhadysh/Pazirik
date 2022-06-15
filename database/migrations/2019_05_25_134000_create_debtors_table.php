<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('factor_id')->unsigned();
            $table->foreign('factor_id')->references('id')->on('factors');
            $table->bigInteger('cheque_id')->unsigned()->nullable();
            $table->foreign('cheque_id')->references('id')->on('cheques');
            $table->string('date');
            $table->bigInteger('cost')->default(0);
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
        Schema::dropIfExists('debtors');
    }
}
