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


//dashboard
Route::get('/dashboard', 'DashboardController@index');

Auth::routes();


Route::get('/getProducts', 'ProductController@getProducts');



Route::get('/mcoat', 'ProductController@mcoatStocksPage');
Route::get('/allied', 'ProductController@alliedStocksPage');


//productout
Route::get('/productout', 'ProductController@productoutPage');
Route::get('/productoutList', 'ProductController@ajaxProductList');
Route::get('/cartList', 'ProductController@ajaxCartList');
Route::get('/cartCount', 'ProductController@ajaxCartCount');
Route::get('/receiptCount', 'ProductController@ajaxReceiptCount');

//cart
Route::get('/getCart/{id}', 'ProductController@getCart');
Route::post('/addToCart', 'ProductController@addToCart');
Route::post('/removeToCart', 'ProductController@removeToCart');

//print
Route::get('/invoice/{id}', 'ProductController@invoice');
Route::post('/saveProductout', 'ProductController@saveProductout');

//productin
Route::get('/productinList', 'ProductController@ajaxProductInList');
Route::get('/productin', 'ProductController@productInPage');
Route::get('/cartListIn', 'ProductController@ajaxCartInList');
Route::get('/cartCountIn', 'ProductController@ajaxCartInCount');
Route::post('/saveProductin', 'ProductController@saveProductin');

//receipts
Route::get('/receipts', 'ReceiptController@receipt');
Route::post('/getReciepts', 'ReceiptController@getReciepts');

Route::get('/receiptin', 'ReceiptController@receiptin');
Route::post('/getRecieptsIn', 'ReceiptController@getRecieptsIn');

//edit receipt
Route::get('/editReceipt/{id}', 'ReceiptController@editReceipt');
Route::post('/getcartReceipt', 'ReceiptController@getcartReceipt');
Route::get('/editProductList', 'ReceiptController@ajaxEditProductList');
Route::post('/editCartList', 'ReceiptController@ajaxEditCartList');
Route::post('/editReceiptCount', 'ReceiptController@ajaxEditReceiptCount');
Route::post('/editCartCount', 'ReceiptController@ajaxCartCount');
Route::post('/editAddToCart', 'ReceiptController@editAddToCart');
Route::post('/editRemoveToCart', 'ReceiptController@editRemoveToCart');

//invoicereceiptin
Route::get('/invoiceReceiptin/{id}', 'ProductController@invoiceReceiptin');

//manage product
Route::get('/manageProduct', 'ProductController@manageProduct');
Route::post('/updateProduct', 'ProductController@updateProduct');
Route::post('/addNewProduct', 'ProductController@addNewProduct');