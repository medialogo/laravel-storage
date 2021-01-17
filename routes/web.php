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
// Route::get('/FS/', 'FSController@index')->name('hello');
Route::get('/FS/{url?}', 'FSController@index')->where('url','.+');
// Route::get('/hello/{msg}', 'HelloController@other');

