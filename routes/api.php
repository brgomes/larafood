<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
], function () {
    Route::get('tenants', 'TenantApiController@index');
    Route::get('tenants/{uuid}', 'TenantApiController@show');

    Route::get('categories', 'CategoryApiController@categoriesByTenant');
    Route::get('categories/{identify}', 'CategoryApiController@show');

    Route::get('tables', 'TableApiController@tablesByTenant');
    Route::get('tables/{identify}', 'TableApiController@show');

    Route::get('products', 'ProductApiController@productsByTenant');
    Route::get('products/{identify}', 'ProductApiController@show');

    Route::post('client', 'Auth\RegisterController@store');
    Route::post('sanctum/token', 'Auth\AuthClientController@auth');
    Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth'], function () {
        Route::get('me', 'Auth\AuthClientController@me');
        Route::get('logout', 'Auth\AuthClientController@logout');

        Route::post('orders', 'OrderApiController@store');
        Route::get('orders', 'OrderApiController@myOrders');

        Route::post('orders/{identifyOrder}/evaluations', 'EvaluationApiController@store');
    });

    Route::get('orders/{identify}', 'OrderApiController@show');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
