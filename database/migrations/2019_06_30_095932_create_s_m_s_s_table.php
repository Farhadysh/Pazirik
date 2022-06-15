<?php

use App\SMS;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSMSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('status');
            $table->string('title');
            $table->text('text')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });

        SMS::create([
            'status' => 1,
            'title' => 'ثبت آدرس'
        ]);
        SMS::create([
            'status' => 2,
            'title' => 'ارسال به راننده'
        ]);
        SMS::create([
            'status' => 3,
            'title' => 'دریافت کالا'
        ]);
        SMS::create([
            'status' => 4,
            'title' => 'تحویل به کارخانه'
        ]);
        SMS::create([
            'status' => 5,
            'title' => 'تحویل به مشتری'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_m_s_s');
    }
}
