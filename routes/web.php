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

Route::post('getOldMessages', 'ChatController@getOldMessages');
Route::get('check', function () {
    return session('chat');
});

Route::get('chat','ChatController@chat');

Route::post('send','ChatController@send');

Route::post('/saveToSession','ChatController@saveToSession');

Route::post('/clearFromSession','ChatController@clearFromSession');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
