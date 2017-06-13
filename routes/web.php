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
Auth::routes();
Route::get('/', ['as'=> 'store', 'uses' => 'ProductsController@index']);
Route::post('purchases', 'PurchaseController@store');
Route::group(['middleware' => 'auth'], function () {

});
// Products
Route::group(['prefix' => 'products'], function() {
	Route::get('/', ['as' => 'products.index', 'uses' => 'ProductsController@index']);
	Route::get('/create', ['as'=> 'products.create', 'uses' => 'ProductsController@create']);
	Route::post('/', ['as'=> 'products.store', 'uses' => 'ProductsController@store']);
	Route::get('{id}/edit', ['as' => 'products.edit', 'uses' => 'ProductsController@edit']);
	Route::patch('{id}', ['as' => 'products.update', 'uses' => 'ProductsController@update']);
});

Route::get('/home', 'HomeController@index')->name('home');
