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

Route::get('/', function () {
    return view('welcome');
});
#Route::get('/disk/FS', 'FSController@index')->name('index');
Route::get('/disk/FS/{url?}', 'FSController@index')->where('url','.*')->name('index');
Route::post('/disk/FS/upload/{url?}', 'FSController@upload')->where('url','.*');
Route::post('/disk/FS/delete', 'FSController@delete');

