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

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// home
Route::get('/', 'HomeController@index')->name('index');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('seller')->namespace('Seller')->name('seller.')->group(function () {
        Route::get('/', 'HomeController@index')->name('index');

        // customer
        Route::match(['get', 'post'], 'customer',   'CustomerController@index')->name('customer.index');
        Route::post('customer/add',                 'CustomerController@store')->name('customer.store');
        Route::resource('customer',                 'CustomerController', ['only' => [
            'update', 'destroy',
        ]]);

        // supplier
        Route::match(['get', 'post'], 'supplier',   'SupplierController@index')->name('supplier.index');
        Route::post('supplier/add',                 'SupplierController@store')->name('supplier.store');
        Route::resource('supplier',                 'SupplierController', ['only' => [
            'update', 'destroy',
        ]]);

        // product
        Route::match(['get', 'post'], 'product',   'ProductController@index')->name('product.index');
        Route::post('product/add',                 'ProductController@store')->name('product.store');
        Route::resource('product',                 'ProductController', ['only' => [
            'update', 'destroy',
        ]]);

        // purchase
        Route::match(['get', 'post'], 'purchase',   'PurchaseController@index')->name('purchase.index');
        Route::post('purchase/add',                 'PurchaseController@store')->name('purchase.store');
        Route::resource('purchase',                 'PurchaseController', ['only' => [
            'update', 'destroy', 'show'
        ]]);

        // Detail Purchase
        Route::post('detail-purchase/add',  'DetailPurchaseController@store')->name('detail-purchase.store');
        Route::resource('detail-purchase',  'DetailPurchaseController', ['only' => [
            'destroy'
        ]]);
        Route::post('detail-purchase/done', 'DetailPurchaseController@done')->name('detail-purchase.done');

        // selling
        Route::match(['get', 'post'], 'selling',    'SellingController@index')->name('selling.index');
        Route::post('selling/add',                  'SellingController@store')->name('selling.store');
        Route::resource('selling',                  'SellingController', ['only' => [
            'update', 'destroy', 'show'
        ]]);

        // Detail Selling
        Route::post('detail-selling/add',   'DetailSellingController@store')->name('detail-selling.store');
        Route::resource('detail-selling',   'DetailSellingController', ['only' => [
            'destroy'
        ]]);
        Route::post('detail-selling/done', 'DetailSellingController@done')->name('detail-selling.done');

        // availability
        Route::match(['get', 'post'], 'availability',   'AvailabilityController@index')->name('availability.index');
        Route::post('availability/add',                 'AvailabilityController@store')->name('availability.store');
        Route::resource('availability',                 'AvailabilityController', ['only' => [
            'update', 'destroy', 'show'
        ]]);

        // Detail availability
        Route::post('detail-availability/add',   'DetailAvailabilityController@store')->name('detail-availability.store');
        Route::resource('detail-availability',   'DetailAvailabilityController', ['only' => [
            'destroy'
        ]]);
        Route::post('detail-availability/done', 'DetailAvailabilityController@done')->name('detail-availability.done');
    });
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Login
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth']], function () {
        // home
        Route::get('/', 'HomeController@index')->name('index');

        // category
        Route::match(['get', 'post'], 'category',   'CategoryController@index')->name('category.index');
        Route::post('category/add',                 'CategoryController@store')->name('category.store');
        Route::resource('category',                 'CategoryController', ['only' => [
            'update', 'destroy',
        ]]);

        // type
        Route::match(['get', 'post'], 'type',   'TypeController@index')->name('type.index');
        Route::post('type/add',                 'TypeController@store')->name('type.store');
        Route::resource('type',                 'TypeController', ['only' => [
            'update', 'destroy',
        ]]);

        // unit
        Route::match(['get', 'post'], 'unit',   'UnitController@index')->name('unit.index');
        Route::post('unit/add',                 'UnitController@store')->name('unit.store');
        Route::resource('unit',                 'UnitController', ['only' => [
            'update', 'destroy',
        ]]);
    });
});
