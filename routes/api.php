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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::get('customer/get-paginate', 'CustomerController@getPaginate');
    Route::get('customer/get-detail', 'CustomerController@getDetail');
    Route::post('customer/insert', 'CustomerController@insert');
    Route::post('customer/update', 'CustomerController@update');
    Route::post('customer/delete', 'CustomerController@delete');

    Route::get('order/get-paginate', 'OrderController@getPaginate');
    Route::get('order/get-detail', 'OrderController@getDetail');
    Route::post('order/insert', 'OrderController@insert');
    Route::post('order/update', 'OrderController@update');
    Route::post('order/delete', 'OrderController@delete');
});

Route::post('register', 'App\Http\Controllers\RegisterController@register');
