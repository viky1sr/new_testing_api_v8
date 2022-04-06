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

Route::group(['prefix' => 'v1'], function() {
    Route::post('login','Api\AuthApiController@login');
    Route::post('logout','Api\AuthApiController@logout');
    Route::post('register','Api\CustomerApiController@register');

    Route::group(['middleware' => 'jwt'], function (){

        /*Admin Role*/
        Route::group(['prefix' => 'customers','middleware' => 'role:admin'], function(){
            Route::get('/','Api\CustomerApiController@getAll');
            Route::get('/{id}','Api\CustomerApiController@getById');
            Route::post('/{id}','Api\CustomerApiController@update');
            Route::delete('/{id}','Api\CustomerApiController@destroy');
        });

        Route::group(['prefix' => 'products','middleware' => 'role:admin'], function (){
            Route::post('/','Api\ProductApiController@create');
            Route::get('/{id}','Api\ProductApiController@getById');
            Route::post('/{id}','Api\ProductApiController@update');
            Route::delete('/{id}','Api\ProductApiController@destroy');
        });
        /*end:Admin Role*/

        Route::get('/products','Api\ProductApiController@getAll');
    });
});
