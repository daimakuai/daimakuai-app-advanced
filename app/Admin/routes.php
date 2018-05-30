<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/welcome', 'HomeController@welcome')->name('welcome');


    Route::group([
        'prefix' => 'china-area',
        'namespace' => 'China',
        'middleware' => ['web', 'admin'],
    ], function (Router $router) {

        $router->resource('province', ProvinceController::class);
        $router->resource('city', CityController::class);
        $router->resource('district', DistrictController::class);

    });


    Route::group([
        'prefix' => 'shop',
        'namespace' => 'Shop',
        'middleware' => ['web', 'admin'],
    ], function (Router $router) {

        $router->resource('address', AddressController::class);
        $router->resource('customer', CustomerController::class);
        $router->resource('store', StoreController::class);
        $router->resource('staff', StaffController::class);
        $router->resource('payment', PaymentController::class);

    });


    $router->resources([
        'tags' => TagController::class,
        'articles' => ArticlesController::class,
        'pages' => PagesController::class,
        'users' => UserController::class,
        'category' => CategoryController::class,
    ]);


    $router->post('articles/release', 'ArticlesController@release');
    $router->post('articles/restore', 'ArticlesController@restore');

    $router->get('api/china-area/city', 'ChinaAreaController@city');
    $router->get('api/china-area/district', 'ChinaAreaController@district');
    $router->get('api/users', 'UserController@users');

    $router->get('api/shop/staffs', 'Shop\\StoreController@staffs');
    $router->get('api/shop/address', 'Shop\\StoreController@address');
    $router->get('api/shop/customers', 'Shop\\PaymentController@customers');


});
