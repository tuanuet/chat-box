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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function () {

    Route::post('files/upload', 'FileController@upload')->name('client-upload');


    Route::post('createToken', 'UserController@createToken');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('getData', 'UserController@getAuthUser');
    });
    Route::post('login', 'AdminVerifyController@login');
    Route::group(['middleware' => 'jwt.authAdmin'], function () {
        Route::get('getAdminData', 'AdminVerifyController@getAdminData');
    });
});