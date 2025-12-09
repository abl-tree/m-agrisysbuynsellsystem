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

Auth::routes();

Route::group(['middleware'=>['auth', 'user:notification']], function() {
    //Notifications
    Route::get('/notification/get', 'NotificationController@get');
    Route::post('/notification/update/{option}', 'NotificationController@update');
    Route::get('notifications', 'NotificationController@index');
});

//profile
Route::get('/profile', 'profileController@index')->name('profile');
Route::post('/oldpass', 'profileController@oldpass')->name('oldpass');
Route::post('/newpass', 'profileController@newpass')->name('newpass');

Route::group(['middleware' => ['auth', 'user:manage_company']], function() {
    //settings
    Route::get('/company', 'companyController@index')->name('company');
    Route::post('/add_company', 'companyController@store')->name('add_company');
    Route::get('/refresh_company', 'companyController@refresh')->name('refresh_company');
    Route::get('/update_company', 'companyController@updatedata')->name('update_company');
    Route::get('/delete_company', 'companyController@deletedata')->name('delete_company');
});

Route::group(['middleware' => ['auth', 'user:manage_employee']], function() {
    Route::get('/employee', 'employeeController@index')->name('employee');
    Route::post('/add_employee', 'employeeController@store')->name('add_employee');
    Route::get('/refresh_employee', 'employeeController@refresh')->name('refresh_employee');
    Route::get('/update_employee', 'employeeController@updatedata')->name('update_employee');
    Route::get('/delete_employee', 'employeeController@deletedata')->name('delete_employee');
});

Route::group(['middleware' => ['auth', 'user:manage_customer']], function() {
    Route::get('/customer', 'customerController@index')->name('customer');
    Route::get('/customerAll', 'customerController@all')->name('customerAll');
    Route::post('/add_customer', 'customerController@store')->name('add_customer');
    Route::get('/refresh_customer', 'customerController@refresh')->name('refresh_customer');
    Route::get('/update_customer', 'customerController@updatedata')->name('update_customer');
    Route::get('/delete_customer', 'customerController@deletedata')->name('delete_customer');
    Route::get('/refresh_balance', 'customerController@updateId')->name('refresh_balance');
});

Route::group(['middleware' => ['auth', 'user:manage_trucks']], function() {
    Route::get('/trucks', 'trucksController@index')->name('trucks');
    Route::post('/add_trucks', 'trucksController@store')->name('add_trucks');
    Route::get('/refresh_trucks', 'trucksController@refresh')->name('refresh_trucks');
    Route::get('/update_trucks', 'trucksController@updatedata')->name('update_trucks');
    Route::get('/delete_trucks', 'trucksController@deletedata')->name('delete_trucks');
});

Route::group(['middleware' => ['auth', 'user:manage_commodity']], function() {
    Route::get('/commodity', 'commodityController@index')->name('commodity');
    Route::post('/add_commodity', 'commodityController@store')->name('add_commodity');
    Route::get('/refresh_commodity', 'commodityController@refresh')->name('refresh_commodity');
    Route::get('/update_commodity', 'commodityController@updatedata')->name('update_commodity');
    Route::get('/delete_commodity', 'commodityController@deletedata')->name('delete_commodity');
    Route::get('/check_commodity', 'commodityController@edit')->name('check_commodity');
    Route::get('/commodity/updates', 'commodityController@show')->name('check_commodity_updates');
});

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/users', 'usersController@index')->name('users');
    Route::post('/add_user', 'usersController@store')->name('add_user');
    Route::get('/refresh_user', 'usersController@refresh')->name('refresh_user');
    Route::get('/update_user', 'usersController@updatedata')->name('update_user');
    Route::get('/delete_user', 'usersController@deletedata')->name('delete_user');
    Route::post('/get_balance', 'usersController@getBalance')->name('get_balance');
    Route::post('/add_cash', 'usersController@addCash')->name('add_cash');
    Route::get('/view_cash_history', 'usersController@viewCashHistory')->name('view_cash_history');
    Route::get('/get/{option}', 'usersController@get');
    Route::post('/permission/{option}', 'usersController@permission')->name('permission');

    Route::get('/roles', 'RolesController@index')->name('roles');
    Route::post('/add_role', 'RolesController@store')->name('add_role');
    Route::get('/refresh_roles', 'RolesController@refresh')->name('refresh_roles');
    Route::get('/update_role', 'RolesController@updatedata')->name('update_role');
    Route::get('/delete_role', 'RolesController@deletedata')->name('delete_role');

});

Route::group(['middleware'=>['auth', 'user:expenses']], function() {
    //EXPENSE
    Route::get('/expense', 'expenseController@index')->name('expense');
    Route::post('/add_expense', 'expenseController@store')->name('add_expense');
    Route::post('/refresh_expense', 'expenseController@refresh')->name('refresh_expense');
    Route::post('/release_update_normal', 'expenseController@release_update_normal')->name('release_update_normal');
    Route::post('/check_balance', 'expenseController@check_balance')->name('check_balance');
    Route::post('/check_balance2', 'expenseController@check_balance2')->name('check_balance2');
    Route::post('/print_expense', 'pdfController@expenses')->name('print_expense');
    Route::post('/trip_expense_view', 'tripController@trip_expense_view')->name('trip_expense_view');
    Route::post('/check_balance_od', 'odController@check_balance_od')->name('check_balance_od');
    Route::post('/od_expense_view', 'odController@od_expense_view')->name('od_expense_view');
    Route::get('/update_expense', 'expenseController@updatedata')->name('update_expense');
    Route::get('/delete_expense', 'expenseController@deletedata')->name('delete_expense');
    Route::get('/getNumber', 'expenseController@getNumber')->name('getNumber');
    Route::post('/release_update', 'tripController@release_update')->name('release_update');
    Route::post('/release_update_od', 'odController@release_update_od')->name('release_update_od');

    //SEARCH AUTOCOMPLETE NAME FOR EXPENSES
    Route::get('autocomplete_name',array('as'=>'autocomplete_name','uses'=>'expenseController@autoComplete'));
}); 

Route::group(['middleware'=>['auth', 'user:trips']], function() {
    //TRIPS
    Route::get('/trips', 'tripController@index')->name('trips');
    Route::post('/print_trip', 'pdfController@trips')->name('print_trip');
});

Route::group(['middleware'=>['auth', 'user:od']], function() {
    //OUTBOUND DELIVERIES 
    Route::get('/outbound', 'odController@index')->name('od');
    Route::post('/refresh_deliveries', 'odController@refresh')->name('refresh_deliveries');
    Route::get('/refresh_id', 'odController@updateId')->name('refresh_id');
    Route::post('/add_delivery', 'odController@store')->name('add_delivery');
    Route::get('/update_delivery', 'odController@updatedata')->name('update_delivery');
    Route::get('/delete_delivery', 'odController@deletedata')->name('delete_delivery');
    Route::post('/print_od', 'pdfController@od')->name('print_od');
});

Route::group(['middleware'=>['auth', 'user:sales']], function() {
    //Sales
    Route::get('/sales', 'salesController@index')->name('sales');
    Route::post('/refresh_sales', 'salesController@refresh')->name('refresh_sales');
    Route::post('/add_sales', 'salesController@store')->name('add_sales');
    Route::get('/update_sales', 'salesController@updatedata')->name('update_sales');
    Route::get('/delete_sales', 'salesController@deletedata')->name('delete_sales');
    Route::post('/print_sales', 'pdfController@sales')->name('print_sales');
    Route::get('/getSales', 'salesController@getSales')->name('getSales');

});

Route::group(['middleware'=>['auth', 'user:manage_prices']], function() {
    //Prices
    Route::get('/price', 'priceController@index')->name('price');
    Route::post('/add_price', 'priceController@store')->name('add_price');
    Route::get('/update_price', 'priceController@updateprice')->name('update_price');
    Route::get('/delete_price', 'priceController@deleteprice')->name('delete_price');
    // Route::post('/print_price', 'pdfController@price')->name('print_price');
    Route::post('/getPriceList', 'priceController@getPriceList')->name('getPriceList');
    Route::post('/getPrices', 'priceController@getPrice')->name('getPrices');

});


Route::group(['middleware'=>['auth', 'user:summary']], function() {
    //Summary
    Route::get('/summary', 'summaryController@index')->name('summary');
    Route::post('/refresh_summary', 'summaryController@refresh')->name('refresh_summary');
    // Route::post('/add_sales', 'salesController@store')->name('add_sales');
    // Route::get('/update_sales', 'salesController@updatedata')->name('update_sales');
    // Route::get('/delete_sales', 'salesController@deletedata')->name('delete_sales');
    // Route::post('/print_sales', 'pdfController@sales')->name('print_sales');
    // Route::get('/getSales', 'salesController@getSales')->name('getSales');

});

Route::group(['middleware'=>['auth', 'user:ca']], function() {
    //CASH ADVANCE
    Route::get('/cashadvance', 'caController@index')->name('ca');
    Route::post('/add_cashadvance', 'caController@store')->name('add_cashadvance');
    Route::get('/refresh_cashadvance', 'caController@refresh')->name('refresh_cashadvance');
    Route::get('/refresh_view_cashadvance', 'caController@refresh_view')->name('refresh_view_cashadvance');
    Route::get('/check_balance', 'caController@check_balance')->name('check_balance');
    Route::get('/getCustomer', 'caController@getCustomer')->name('getCustomer');
    Route::get('/refresh_balancedt', 'balanceController@refresh')->name('refresh_balancedt');
    Route::get('/toReceive', 'balanceController@toReceive')->name('toReceive');
    Route::get('/balancelogs', 'balanceController@balance')->name('balancelogs');
    Route::get('/hasbalance', 'balanceController@hasbalance')->name('hasbalance');
    Route::post('/add_payment', 'balanceController@add_payment')->name('add_payment');
    Route::post('/delete_cutomer_payment', 'balanceController@delete_payment')->name('delete_cutomer_payment');
    Route::post('/receive_payment_customer', 'balanceController@receive')->name('receive_payment_customer');
    Route::post('/print_ca', 'pdfController@ca')->name('print_ca');
    Route::post('/print_balance_payment', 'pdfController@balance_payment')->name('print_balance_payment');
    Route::post('/release_ca', 'caController@release_update')->name('release_ca');
    Route::post('/check_balance4', 'caController@check_balance4')->name('check_balance4');
    Route::get('/update_ca', 'caController@updatedata')->name('update_ca');
    Route::get('/delete_ca', 'caController@deletedata')->name('delete_ca');
});

Route::group(['middleware'=>['auth', 'user:purchases']], function() {
    //PURCHASES
    Route::get('/purchases', 'purchasesController@index')->name('purchases');
    Route::get('/update_purchases', 'purchasesController@updatedata')->name('update_purchases');
    Route::get('/delete_purchases', 'purchasesController@deletedata')->name('delete_purchases');
    Route::get('/find_amt', 'purchasesController@findAmount')->name('find_amt');
    Route::get('/refresh_trans', 'purchasesController@updateId')->name('refresh_trans');
    Route::get('/findCustomer', 'purchasesController@updatecustomerId')->name('findCustomer');
    Route::get('/find_comm', 'purchasesController@findcomm')->name('find_comm');
    Route::post('/add_purchases', 'purchasesController@store')->name('add_purchases');
    Route::post('/refresh_purchases', 'purchasesController@refresh')->name('refresh_purchases');
    Route::post('/print_purchase', 'pdfController@purchases')->name('print_purchase');
    Route::post('/release_purchase', 'purchasesController@release_purchase')->name('release_purchase');
    Route::post('/check_balance3', 'purchasesController@check_balance3')->name('check_balance3');
    Route::post('cash/sync', 'purchasesController@sync_cash_history')->name('sync_cash');
});

Route::group(['middleware'=>['auth', 'user:dtr']], function() {
    //DTR
    Route::get('/check_employee', 'dtrController@check_employee')->name('check_employee');
    Route::get('/dtr_details', 'dtrController@dtr_details')->name('dtr_details');
    Route::get('/refresh_dtr', 'dtrController@refresh')->name('refresh_dtr');
	Route::get('/refresh_view_total', 'dtrController@refresh_total')->name('refresh_view_total');
    Route::post('/add_dtr', 'dtrController@store')->name('add_dtr');
    Route::post('/add_dtr_expense', 'dtrController@add_dtr_expense')->name('add_dtr_expense');
    Route::get('/dtr', 'dtrController@index')->name('dtr');
    Route::post('/print_dtr', 'pdfController@dtr')->name('print_dtr');
    Route::post('/check_balance5', 'dtrController@check_balance5')->name('check_balance5');
    Route::get('/update_dtr', 'dtrController@updatedata')->name('update_dtr');
    Route::get('/delete_dtr', 'dtrController@deletedata')->name('delete_dtr');
    Route::get('/check_emp_balance', 'dtrController@check_emp_balance')->name('check_emp_balance');
    Route::post('/emp_add_cashadvance', 'dtrController@add_emp_ca')->name('emp_add_cashadvance');
    Route::get('/employee_view_ca', 'dtrController@employee_view_ca')->name('employee_view_ca');
    Route::get('/employee_view_payment', 'dtrController@employee_view_payment')->name('employee_view_payment');
    Route::post('/add_payment_emp', 'dtrController@emp_payment')->name('add_payment_emp');
    Route::post('/check_balance_user', 'dtrController@check_balance_user')->name('check_balance_user');
    Route::post('/release_ca_employee', 'dtrController@release_ca_employee')->name('release_ca_employee');
    Route::get('/delete_ca_employee', 'dtrController@delete_ca_employee')->name('delete_ca_employee');
    Route::get('/employee_balance', 'dtrController@employee_balance')->name('employee_balance');
    Route::get('/refresh_view_dtr', 'dtrController@refresh_view')->name('refresh_view_dtr');
    Route::post('/release_update_dtr', 'dtrController@release_update_dtr')->name('release_update_dtr');
    Route::post('/receive_payment', 'dtrController@receive_payment')->name('receive_payment');
    Route::post('/delete_payment', 'dtrController@delete_payment')->name('delete_payment');
});

Route::group(['middleware'=>['auth', 'user:trips']], function() {
    //PICK UP
    Route::get('/get_pickup', 'tripController@updateId')->name('get_pickup');
    Route::post('/refresh_pickup', 'tripController@refresh')->name('refresh_pickup');
    Route::get('/update_pickup', 'tripController@updatedata')->name('update_pickup');
    Route::get('/delete_trip', 'tripController@deletedata')->name('delete_trip');
    Route::post('/add_pickup', 'tripController@store')->name('add_pickup');
    Route::post('/update_trip', 'tripController@update_trip')->name('update_trip');
});

Route::group(['middleware'=>['auth']], function() {
    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/sales_today', 'HomeController@sales_today');
    Route::get('/purchases_today', 'HomeController@purchases_today');
    Route::get('/purchases/today', 'HomeController@totalPurchasesToday');
    Route::get('/balance_today', 'HomeController@balance_today');
    Route::get('/expenses_today', 'HomeController@expenses_today');
    Route::get('/cash_on_hand', 'HomeController@cashOnHand');
});
