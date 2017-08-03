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


Route::get('/room',['name'=>'get.room', 'uses'=>'RoomController@index']);
Route::get('history', ['name' => 'get.history', 'uses' => 'RoomController@history']);
Route::get('/room/{id}', 'RoomController@showChatLog');
Route::get('/chat/{id}', 'RoomController@chat');

Route::get('room/datatables', 'RoomController@getDataTable')->name('room.datatables');

Route::get('/','DashboardController@getDashboard');
///////////////////////////////////////
///
///////////////Route of Admin/////////////////
Route::get('admin', 'AdminController@index');

Route::post('admin/add', 'AdminController@add');

Route::get('admin/profile', 'AdminController@profile');
Route::post('admin/profile/update', 'AdminController@update');
//////////////////////////////////////////////

/////////////////Route login////////////////////
Route::get('login', 'AdminLogin@index');
Route::post('login', 'AdminLogin@login')->name('admin-login');

Route::get('admin/logout', 'AdminLogin@logout')->name('admin-logout');

Route::get('admin/room', 'RoomController@index')->name('room-index');
////////////////////////////////////////////////

///////////////////ROUTE CUSTOMER///////////////
Route::get('customers', 'CustomerController@index');
Route::get('customers/getroom', 'CustomerController@getRoom');

Route::post('customers/add', 'CustomerController@add');
Route::post('customers/edit', 'CustomerController@edit');


////////////////////////////////////////////////

//////////////////ROUTE TOPIC///////////////////
Route::get('topics', 'TopicController@index');

Route::post('topics/delete', 'TopicController@delete');
Route::post('topics/add', 'TopicController@add');
Route::post('topics/edit', 'TopicController@edit');
///////////////////////////////////////////////

///////////////////////FILE////////////////////
Route::get('files', 'FileController@index');
Route::get('file', 'FileController@getfile');
Route::get('download', 'FileController@download');

Route::post('files/upload', 'FileController@upload');

//////////////////////////////////////////////
