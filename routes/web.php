<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\ChangeFactor;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect('/admin');
});

Route::name('admin.')->namespace('Admin')->middleware('auth')->prefix('admin')->group(function () {

    Route::get('/', function () {
        $user_count = User::where('level','user')->count();
        $Transmitted = Order::where('status',2)->count();
        return view('admin.index')->with([
            'user_count' => $user_count,
            'Transmitted' => $Transmitted
        ]);
    });

    Route::get('/location', function () {
        return view('admin.locations.location');
    });

    Route::get('/customers/search', 'CustomerController@search')->name('customers.search');
    Route::get('/customers/excel', 'CustomerController@excel')->name('customers.excel');
    Route::get('/customers/mobile_search/{mobile}', 'CustomerController@mobile_search')->name('customers.mobile_search');
    Route::post('/customers/address_update/{id}', 'CustomerController@address_update')->name('customers.address_update');

    Route::resource('customers', 'CustomerController');
    Route::resource('roles', 'RoleController');
    Route::resource('notes', 'NoteController');
    Route::get('/costExcel', 'CostController@costExcel')->name('costs.costExcel');
    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::post('/settings/update/{id}', 'SettingController@update')->name('settings.update');
    Route::resource('costs', 'CostController');
    Route::resource('addresses', 'AddressController')->only(['update']);
    Route::get('/factorExcel', 'FactorController@factorExcel')->name('factors.factorExcel');
    Route::get('/factors/search', 'FactorController@search')->name('factors.search');
    Route::get('/factors/driver_factor/{factor}', 'FactorController@driver_factor')->name('factors.driver_factor');
    Route::post('/factors/ProductFactor_create', 'FactorController@ProductFactor_create')->name('factors.ProductFactor_create');
    Route::delete('/factors/ProductFactor_destroy/{factorProduct}', 'FactorController@ProductFactor_destroy')->name('factors.ProductFactor_destroy');
    Route::resource('factors', 'FactorController');
    Route::get('/factors/installmentEdit/{factor}', 'FactorController@installmentEdit')->name('factors.installmentEdit');
    Route::post('/factors/addNote', 'FactorController@addNote')->name('factors.addNote');
    Route::resource('shifts', 'ShiftController');
    Route::get('/users/change_active/{id}/{active}', 'UserController@check_active');
    Route::get('/users/changePassword/{user}', 'UserController@changePassword')->name('users.changePassword');
    Route::resource('users', 'UserController');
    Route::get('/orders/mark/{id}/{active}', 'OrderController@mark');
    Route::get('/orderExcel', 'OrderController@orderExcel')->name('orders.orderExcel');
    Route::get('/orders/search', 'OrderController@search')->name('orders.search');
    Route::get('/Delivery_To_Factory/{order}', 'OrderController@Delivery_To_Factory')->name('orders.Delivery_To_Factory');
    Route::get('/Delivery_To_customer/{order}', 'OrderController@Delivery_To_customer')->name('orders.Delivery_To_customer');
    Route::post('/Delivered_To_customer/{order}', 'OrderController@Delivered_To_customer')->name('orders.Delivered_To_customer');
    Route::resource('orders', 'OrderController');
    Route::get('/products/product_active/{id}/{active}', 'ProductController@product_active');
    Route::resource('products', 'ProductController');
    Route::resource('debtors', 'DebtorController');
    Route::resource('cheques', 'ChequeController');
    Route::resource('offices', 'OfficeController');
    Route::post('/update_des', 'MarkController@update_des')->name('marks.update_des');
    Route::get('/mark_filter', 'MarkController@mark_filter')->name('marks.mark_filter');
    Route::resource('marks', 'MarkController');


    Route::name('reports.')->prefix('reports')->group(function () {
        Route::get('/accounting', 'ReportController@accounting')->name('accounting');
        Route::get('/paid', 'ReportController@paid')->name('paid');
        Route::get('/productReports', 'ReportController@productReports')->name('productReports');
        Route::get('/accounting/search', 'ReportController@accountingSearch')->name('accounting.search');
        Route::get('/accountingExcel', 'ReportController@accountingExcel')->name('accounting.accountingExcel');
        Route::get('/paidExcel', 'ReportController@paidExcel')->name('accounting.paidExcel');
        Route::get('/productExcel', 'ReportController@productExcel')->name('accounting.productExcel');
        Route::get('/paid/search', 'ReportController@paidSearch')->name('accounting.paidSearch');
        Route::get('/productReports/search', 'ReportController@searchProducts')->name('products.search');
        Route::get('/checkOut/{factor}', 'ReportController@checkOut')->name('checkOut');
    });

    Route::name('changes.')->prefix('changes')->group(function () {
        Route::get('/index', 'ChangeFactorController@index')->name('index');
        Route::get('/show/{factor}', 'ChangeFactorController@show')->name('show');
        Route::get('/search', 'ChangeFactorController@search')->name('search');
    });


    Route::name('waits.')->prefix('waits')->group(function () {
        Route::get('/', 'WaitingController@index')->name('index');
        Route::post('/Transmitted', 'WaitingController@Transmitted')->name('Transmitted');
        Route::post('/notTransmitted', 'WaitingController@notTransmitted')->name('notTransmitted');
        Route::get('/search', 'WaitingController@search')->name('search');
        Route::get('/transport_all', 'WaitingController@transport_all')->name('transport_all');
        Route::get('/edit/{order}', 'WaitingController@edit')->name('edit');
        Route::post('/update/{order}', 'WaitingController@update')->name('update');
        Route::post('/destroy/{order}', 'WaitingController@destroy')->name('destroy');
    });


    Route::name('SMS.')->prefix('SMS')->group(function () {
        Route::get('/fluttering', 'SMSController@fluttering')->name('fluttering');
        Route::get('/edit', 'SMSController@edit')->name('edit');
        Route::get('/change_status/{id}/{status}', 'SMSController@status');
    });
});


