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
////////Dashboard/////////////////
Route::get('/dashboard','DashboardController@getDashboard');

Route::get('/','DashboardController@getDashboard');
///////////////////////////////////////
///
///////////////Route of Admin/////////////////
Route::get('admin', 'AdminController@index');

Route::post('admin/add', 'AdminController@add');
//////////////////////////////////////////////

/////////////////Route login////////////////////
Route::get('login', 'AdminLogin@index');
Route::post('login', 'AdminLogin@login')->name('admin-login');

Route::get('admin/logout', 'AdminLogin@logout')->name('admin-logout');

Route::get('admin/room', 'RoomController@index')->name('room-index');
////////////////////////////////////////////////

///////////////////ROUTE CUSTOMER///////////////
Route::get('customers', 'CustomerController@index');

Route::post('customers/add', 'CustomerController@add');
Route::post('customers/edit', 'CustomerController@edit');
////////////////////////////////////////////////