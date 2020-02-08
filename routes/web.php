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
Route::get('/',                     'HomeController@index')->name('index');
Route::get('about',                 'HomeController@about')->name('about');
Route::get('product',               'ProductController@index')->name('product.index');
Route::get('product/detail/{id}',   'ProductController@show')->name('product.show');

Route::get('umkm/category/{id}',    'UMKMController@category')->name('umkm.category');
Route::get('umkm/detail/{id}',      'UMKMController@detail')->name('umkm.detail');

Route::group(['middleware' => ['auth', 'member']], function () {
    // profile
    Route::get('/profile',                          'ProfileController@index')->name('profile.index');
    Route::post('/profile/change-password/{id}',    'ProfileController@changePassword')->name('profile.change-password');
    Route::post('/profile/change-setting/{id}',     'ProfileController@changeSetting')->name('profile.change-setting');

    // cart
    Route::match(['get', 'post'], 'cart',   'CartController@index')->name('cart.index');
    Route::post('cart/add',                 'CartController@store')->name('cart.store');
    Route::resource('cart',                 'CartController', ['only' => [
        'update', 'destroy'
    ]]);

    // invoice
    Route::get('invoice',                                   'InvoiceController@index')->name('invoice.index');
    Route::post('invoice/add',                              'InvoiceController@store')->name('invoice.store');

    Route::get('invoice/pending/{id}',                      'InvoiceController@pending')->name('invoice.pending');
    Route::get('invoice/page-payment/{id}',                 'InvoiceController@pagePayment')->name('invoice.page-payment');
    Route::get('invoice/canceled/{id}',                     'InvoiceController@canceled')->name('invoice.canceled');
    Route::get('invoice/approve/{id}',                      'InvoiceController@approve')->name('invoice.approve');
    Route::get('invoice/reject/{id}',                       'InvoiceController@reject')->name('invoice.reject');

    Route::post('invoice/payment',                          'InvoiceController@payment')->name('invoice.payment');
    Route::post('invoice/cancel',                           'InvoiceController@cancel')->name('invoice.cancel');

});

Route::group(['middleware' => ['auth', 'seller']], function () {
    Route::prefix('seller')->namespace('Seller')->name('seller.')->group(function () {
        Route::get('/', 'HomeController@index')->name('index');

        // profile
        Route::get('/profile',                          'ProfileController@index')->name('profile.index');
        Route::post('/profile/change-password/{id}',    'ProfileController@changePassword')->name('profile.change-password');
        Route::post('/profile/change-setting/{id}',     'ProfileController@changeSetting')->name('profile.change-setting');
        Route::post('/profile/change-location/{id}',    'ProfileController@changeLocation')->name('profile.change-location');

        // seller
        Route::match(['get', 'post'], 'seller',   'SellerController@index')->name('seller.index');

        // bank
        Route::match(['get', 'post'], 'bank',   'BankController@index')->name('bank.index');
        Route::post('bank/add',                 'BankController@store')->name('bank.store');
        Route::resource('bank',                 'BankController', ['only' => [
            'update',
        ]]);

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

        // selling-online
        Route::match(['get', 'post'], 'selling-online',    'SellingOnlineController@index')->name('selling-online.index');
        Route::resource('selling-online',                  'SellingOnlineController', ['only' => [
            'show'
        ]]);
        Route::post('selling-online/approve',               'SellingOnlineController@approve')->name('selling-online.approve');
        Route::post('selling-online/reject',                'SellingOnlineController@reject')->name('selling-online.reject');

        // assembly
        Route::match(['get', 'post'], 'assembly',   'AssemblyController@index')->name('assembly.index');
        Route::post('assembly/add',                 'AssemblyController@store')->name('assembly.store');
        Route::resource('assembly',                 'AssemblyController', ['only' => [
            'update', 'destroy', 'show'
        ]]);

        // Product Assembly
        Route::post('product-assembly/add',   'ProductAssemblyController@store')->name('product-assembly.store');
        Route::resource('product-assembly',   'ProductAssemblyController', ['only' => [
            'destroy'
        ]]);

        // Detail Assembly
        Route::post('detail-assembly/add',   'DetailAssemblyController@store')->name('detail-assembly.store');
        Route::resource('detail-assembly',   'DetailAssemblyController', ['only' => [
            'destroy'
        ]]);
        Route::post('detail-assembly/done', 'DetailAssemblyController@done')->name('detail-assembly.done');

        // report selling
        Route::match(['get', 'post'], 'report-selling',     'ReportSellingController@index')->name('report-selling.index');

        // report purchase
        Route::match(['get', 'post'], 'report-purchase',    'ReportPurchaseController@index')->name('report-purchase.index');

        // report stock
        Route::match(['get', 'post'], 'report-stock',       'ReportStockController@index')->name('report-stock.index');

        // report profit
        Route::match(['get', 'post'], 'report-profit',       'ReportProfitController@index')->name('report-profit.index');
    });
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Login
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth', 'admin']], function () {
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

        // management-seller
        Route::match(['get', 'post'], 'management-seller',   'ManagementSellerController@index')->name('management-seller.index');
        Route::resource('management-seller',                 'ManagementSellerController', ['only' => [
            'show',
        ]]);
        Route::post('management-seller/approve',               'ManagementSellerController@approve')->name('management-seller.approve');
        Route::post('management-seller/reject',                'ManagementSellerController@reject')->name('management-seller.reject');

        // management-member
        Route::match(['get', 'post'], 'management-member',   'ManagementMemberController@index')->name('management-member.index');
    });
});
