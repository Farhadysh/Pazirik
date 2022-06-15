<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('level', ['admin', 'driver', 'user'])->default('user');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('mobile', 11)->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('national_code', 10)->nullable();
            $table->string('car_number')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        User::create([
            'level' => 'admin',
            'name' => 'bttech',
            'username' => 'bttech',
            'mobile' => '09369659255',
            'password' => Hash::make(123456),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
