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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/admin', 'HomeController@index');

Auth::routes();


Route::get('/getProducts', 'ProductController@getProducts');



Route::get('/mcoat', 'ProductController@mcoatStocksPage');
Route::get('/allied', 'ProductController@alliedStocksPage');
Route::get('/productout', 'ProductController@productoutPage');

//ajax
Route::get('/productoutList', 'ProductController@ajaxProductList');
Route::get('/cartList', 'ProductController@ajaxCartList');
Route::get('/cartCount', 'ProductController@ajaxCartCount');

//cart
Route::get('/getCart', 'ProductController@getCart');
Route::post('/addToCart', 'ProductController@addToCart');
Route::post('/removeToCart', 'ProductController@removeToCart');

//print
Route::get('/invoice/{id}', 'ProductController@invoice');
Route::post('/saveProductout', 'ProductController@saveProductout');