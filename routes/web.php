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

Route::get('/', 'HomeController@index');

//dashboard
Route::get('/dashboard', 'DashboardController@index');
Auth::routes();
Route::post('login', 'Auth\LoginController@authenticate')->name('login');

Route::post('/savebio', 'UserController@saveBioData');
Route::get('/getProducts', 'ProductController@getProducts');



Route::group(['prefix'=>'admin','middleware' => 'isAdmin'], function(){

    Route::get('/getProducts', 'ProductController@getProducts');

    Route::get('/mcoat', 'ProductController@mcoatStocksPage');
    Route::get('/allied', 'ProductController@alliedStocksPage');

    Route::get('/productout', 'ProductController@productoutPage');
    Route::get('/alliedproductout', 'ProductController@alliedProductoutPage');

    Route::get('/productin', 'ProductController@productInPage');
    Route::get('/alliedproductin', 'ProductController@productAlliedInPage');

    //manage product
    Route::get('/manageProduct', 'ProductController@manageProduct');

    //allied manage product
    Route::get('/alliedmanageproduct', 'ProductController@alliedManageProduct');

    //graph
    Route::get('/fastMovingProducts', 'ProductController@fastMovingProducts');
    Route::get('/fastMovingProducts', 'ProductController@fastMovingProducts');

    //users
    Route::get('/users', 'UserController@userPage');
    Route::get('/getusers', 'UserController@getUsers');
    Route::post('/approveDisapproveUser', 'UserController@approveDisapproveUser');
    Route::post('/approveDisapproveUserAdmin', 'UserController@approveDisapproveUserAdmin');

    //employee
    Route::get('/employees', 'UserController@employeePage');
    Route::get('/getemployee', 'UserController@getEmployee');
    Route::get('/biodata/{id}', 'UserController@pdfBiodata');

    //reset
    Route::get('/reset', 'ProductController@resetPage');
    Route::get('/resetmcoat', 'ProductController@ajaxMcoatResetList');
    Route::get('/resetallied', 'ProductController@ajaxAlliedResetList');
    Route::post('/resetproduct', 'ProductController@resetProduct');
    Route::get('/getresetted', 'ProductController@getResetted');
    Route::post('/undoreset', 'ProductController@undoReset');

    Route::get('/branchsales', 'SupplierBranchController@branchSalePage');
    Route::get('/branch/{id}', 'SupplierBranchController@perBranch');

    Route::get('/notifications/{limit}', 'Controller@getNotifications');
    Route::get('/activity', 'UserController@activityPage');

    Route::get('/warehouse', 'SupplierBranchController@warehouse');
    Route::get('/getwarehouse', 'SupplierBranchController@getWarehouse');
    Route::post('/updatewarehouse', 'SupplierBranchController@updateWarehouse');
    Route::post('/addwarehouse', 'SupplierBranchController@addwarehouse');


});


Route::group(['prefix'=>'semi','middleware' => 'isUser1'], function(){
    Route::get('/products', 'ProductController@stocksPage');
    Route::get('/manage', 'ProductController@manage');
    Route::get('/productout', 'ProductController@productOut');
    Route::get('/productin', 'ProductController@productIn');
    Route::get('/employees/{id}', 'UserController@employeeeBiodata');

});


Route::group(['prefix'=>'user','middleware' => 'isUser2'], function(){
    Route::get('/products', 'ProductController@stocksPage');
    //employee

    Route::get('/employees/{id}', 'UserController@employeeeBiodata');
});


//shared
Route::group(['middleware' => 'isShared'], function(){

//manage product
    Route::post('/updateProduct', 'ProductController@updateProduct');
    Route::post('/addNewProduct', 'ProductController@addNewProduct');

//productout
    Route::get('/productoutList', 'ProductController@ajaxProductList');
    Route::get('/cartList', 'ProductController@ajaxCartList');
    Route::get('/cartCount', 'ProductController@ajaxCartCount');
    Route::get('/receiptCount', 'ProductController@ajaxReceiptCount');


    Route::get('/alliedproductoutlist', 'ProductController@ajaxAlliedProductList');
    Route::get('/alliedcartlist', 'ProductController@ajaxAlliedCartList');
    Route::get('/alliedcartcount', 'ProductController@ajaxAlliedCartCount');
    Route::get('/alliedreceiptcount', 'ProductController@ajaxAlliedReceiptCount');

//cart
    Route::get('/getCart/{id}', 'ProductController@getCart');
    Route::post('/addToCart', 'ProductController@addToCart');
    Route::post('/removeToCart', 'ProductController@removeToCart');
    Route::post('/editquantity', 'ProductController@editQuantity');

//print
    Route::get('/invoice/{id}', 'ProductController@invoice');
    Route::get('/invoice/{view}/{id}', 'ProductController@invoice');
    Route::post('/saveProductout', 'ProductController@saveProductout');

//product in
    Route::get('/productinList', 'ProductController@ajaxProductInList');
    Route::get('/cartListIn', 'ProductController@ajaxCartInList');
    Route::get('/cartCountIn', 'ProductController@ajaxCartInCount');
    Route::post('/saveProductin', 'ProductController@saveProductin');

    Route::get('/alliedproductinlist', 'ProductController@ajaxAlliedProductInList');
    Route::get('/alliedcartlistin', 'ProductController@ajaxAlliedCartInList');
    Route::get('/alliedcartcountin', 'ProductController@ajaxAlliedCartInCount');

    //receipts
    Route::get('/receipts', 'ReceiptController@receipt');
    Route::post('/getReciepts', 'ReceiptController@getReciepts');

    Route::get('/receiptin', 'ReceiptController@receiptin');
    Route::post('/getRecieptsIn', 'ReceiptController@getRecieptsIn');

    //invoicereceiptin
    Route::get('/invoiceReceiptin/{id}', 'ProductController@invoiceReceiptin');


    //stocksreport
    Route::get('/stocksreport', 'ReceiptController@stocksReport');
    Route::get('/pricelist/{brand}/{category}', 'ReceiptController@priceList');
    Route::get('/pricelist/{brand}', 'ReceiptController@priceList');

    Route::post('/brandCategory', 'ReceiptController@brandCategory');

    Route::get('/stocklist/{stock}/{brand}/{category}/{description}/{unit}', 'ReceiptController@stockList');
    Route::get('/stocklists/{offset}/{type}', 'ReceiptController@stockListAll');

    //suppliers
    Route::get('/suppliers', 'SupplierBranchController@supplierPage');
    Route::get('/getsuppliers', 'SupplierBranchController@getSuppliers');
    Route::post('/updatesupplier', 'SupplierBranchController@updateSupplier');
    Route::post('/deleteitems', 'SupplierBranchController@deleteItems');

    //branches
    Route::get('/branches', 'SupplierBranchController@branchPage');
    Route::get('/getbranches', 'SupplierBranchController@getBranches');
    Route::post('/updatebranch', 'SupplierBranchController@updateBranch');
    Route::post('/addbranch', 'SupplierBranchController@addbranch');

    //edit receipt
    Route::get('/editReceipt/{id}', 'ReceiptController@editReceipt');
    Route::post('/getcartReceipt', 'ReceiptController@getcartReceipt');
    Route::get('/editProductList/{type}', 'ReceiptController@ajaxEditProductList');
    Route::post('/editCartList', 'ReceiptController@ajaxEditCartList');
    Route::post('/editReceiptCount', 'ReceiptController@ajaxEditReceiptCount');
    Route::post('/editCartCount', 'ReceiptController@ajaxCartCount');
    Route::post('/editAddToCart', 'ReceiptController@editAddToCart');
    Route::post('/editRemoveToCart', 'ReceiptController@editRemoveToCart');
    Route::post('/ajaxSaveToTemp', 'ReceiptController@ajaxSaveToTemp');
    Route::post('/updateReceipt', 'ReceiptController@updateReceipt');

    //ajax
    Route::post('/getdeliveredto', 'ReceiptController@getDeliveredTo');

    //sale
    Route::post('/dailysale', 'SaleController@saveDailySale');

    Route::get('/monthlysale', 'SaleController@getMonthlySales');

    //accountsettings
    Route::get('/accountsetting/{id}', 'UserController@accountSettings');
    Route::post('/updateaccount', 'UserController@updateAccount');


});
