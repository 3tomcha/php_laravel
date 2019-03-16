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

Route::group(['prefix' => 'admin/news', 'middleware' => 'auth'],function(){
  Route::get('/create', 'Admin\NewsController@add');
  Route::post('/create', 'Admin\NewsController@create');
  Route::get('/', 'Admin\NewsController@index');
  Route::get('/edit', 'Admin\NewsController@edit');
  Route::post('/edit', 'Admin\NewsController@update');
  Route::get('/delete', 'Admin\NewsController@delete');
});

Route::group(['prefix' => 'admin/profile', 'middleware' => 'auth'],function(){
  Route::get('/create','Admin\ProfileController@add');
  Route::post('/create','Admin\ProfileController@create');
  Route::get('/edit','Admin\ProfileController@edit');
  Route::post('/edit','Admin\ProfileController@update');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// Route::post
// Route
