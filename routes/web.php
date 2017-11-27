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

use Illuminate\Routing\Router;


Route::group([
    'prefix'        => '',
    'namespace'      =>'Home',
    'middleware'    => 'web',
], function (Router $router) {
    $router->get('/',  'HomeController@index');
    $router->get('/welcome',  'HomeController@welcome');
});

