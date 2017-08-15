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

/////////////////Route login////////////////////
Route::get('login', 'AdminLogin@index')->name('login-admin');
Route::post('login', 'AdminLogin@login')->name('admin-login');
////////////////////////////////////////////////

Route::post('getBundle', 'AdminConfigureController@runConfigure');


//Route::post('getlink', 'DashboardController@getLink')->name('get-link');
Route::group(['middleware' => 'jwt.authAdmin'], function () {

    ////////Dashboard/////////////////
    Route::get('/dashboard','DashboardController@getDashboard');


    Route::get('admin/room', 'RoomController@index')->name('room-index');

    Route::get('/','DashboardController@getDashboard');
    ///////////////////////////////////////

    ///////////////Route of Admin/////////////////
    Route::get('admin', 'AdminController@index');

    Route::post('admin/add', 'AdminController@add');

    Route::get('admin/profile', 'AdminController@profile');
    Route::post('admin/profile/update', 'AdminController@update');
    //////////////////////////////////////////////

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
    Route::get('file', 'FileController@getFile');
    Route::get('download', 'FileController@download');

    Route::post('files/upload', 'FileController@upload')->name('uploadIMG');
    Route::post('files/adminupload', 'FileController@adminUpload')->name('admin-upload');
    Route::post('files/delete', 'FileController@delete')->name('delete-a-file');
    //////////////////////////////////////////////

    /// Admin-logout///
    Route::get('admin/logout', 'AdminLogin@logout')->name('admin-logout');


    Route::get('/room', function () {
        return view('index');
    });

    ////////////////////Config chat//////////////////////////////

    ////////////////////////////////////////////////////////////
    Route::get( '/_debugbar/assets/stylesheets', '\Barryvdh\Debugbar\Controllers\AssetController@css' );
    Route::get( '/_debugbar/assets/javascript', '\Barryvdh\Debugbar\Controllers\AssetController@js' );


//Route::get('{reactRoutes}', function () {
//    return view('index'); // your start view
//})->where('reactRoutes', '^((?!api).)*$');
});

