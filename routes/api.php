<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'API\v1'], function () {
    Route::resource('factors', 'FactorController');
    Route::post('login', 'UserController@login');
    Route::resource('products', 'ProductController')->only('index');
    Route::get('orders/{id}', 'OrderController@driverOrders');
});
