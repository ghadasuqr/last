<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------*/
 ###============================== ***    BACK END   *** =====================================###
/*===================================================================================== */
#index backend--------------------
// Route::get('dashboard/', function () {
//     return view('backend.layouts.index');
// });
# redirect -- 
Route::get('dashboard/' ,"backend\appBackCtrl@adminIndex");
#retuen most Sold for Admin included in index admin page
#- logout-- 
Route::get('logoutBack' ,"backend\appBackCtrl@logoutBack");
#-users for Admin--------------------------------------------------------------Users
Route::get('dashboard/getUsers' ,"backend\appBackCtrl@getUsersAdmin");
Route::get('dashboard/blockedUsers' ,"backend\appBackCtrl@blockedUsersAdmin");

Route::post('dashboard/block/{id}' ,"backend\appBackCtrl@blockUser");
Route::post('dashboard/activate/{id}' ,"backend\appBackCtrl@activateUser");
// Route::post('dashboard/update/{id}' ,"backend\appBackCtrl@updateRole");
// Route::get('dashboard/getUsers' ,"backend\appBackCtrl@getUsersAdmin");
#========================================================================== Comments 
Route::get('dashboard/comments' ,"backend\appBackCtrl@getComments");
Route::post('dashboard/comments/delete/{id}' ,"backend\appBackCtrl@deleteComment");
#===========================================================================Most Sold  ,, MostRated  ,, Latest PAGES Admin 
Route::get('dashboard/mostSoldAdminPage','backend\appBackCtrl@mostSoldAdminPage');
Route::get('dashboard/mostRatedAdminPage','backend\appBackCtrl@mostRatedAdminPage');



#index Backend---------------------------------------------

#categories---------------------------------------------------------
Route::get('category',"backend\categoryCtr@index" );
Route::get('category/create',"backend\categoryCtr@create" );
Route::post('category/create',"backend\categoryCtr@store" );
Route::get('category/edit/{catId}',"backend\categoryCtr@edit" );
Route::post('category/edit/{catId}',"backend\categoryCtr@update" );
Route::get('category/destroy/{catId}',"backend\categoryCtr@destroy" );
Route::get('category/show/{catId}',"backend\categoryCtr@show" );
#categories---------------------------------------------------------

#Models------------------------------------------------------------------
Route::get('dashboard/models' , 'backend\ModelCtrl@index');
Route::get('dashboard/models/create' , 'backend\ModelCtrl@create');
Route::post('dashboard/models/create' , 'backend\ModelCtrl@store');
Route::get('dashboard/models/edit/{modelNo}' , 'backend\ModelCtrl@edit');
Route::post('dashboard/models/edit/{modelNo}' , 'backend\ModelCtrl@update');
Route::post('dashboard/models/destroy/{modelNo}' , 'backend\ModelCtrl@destroy');
Route::post('dashboard/models/show/{modelNo}' , 'backend\ModelCtrl@show');
#Models------------------------------------------------------------------

#items-------------------------------------------------------------
Route::get('dashboard/items' , 'backend\itemCtrl@index');
Route::get('dashboard/hiddenItems' , 'backend\itemCtrl@getHidden');
Route::get('dashboard/items/create' , 'backend\itemCtrl@create');
Route::post('dashboard/items/create' , 'backend\itemCtrl@store');
Route::get('dashboard/items/edit/{code}' , 'backend\itemCtrl@edit');
Route::post('dashboard/items/edit/{code}' , 'backend\itemCtrl@update');
Route::post('dashboard/items/destroy/{code}' , 'backend\itemCtrl@destroy');
Route::post('dashboard/items/show/{code}' , 'backend\itemCtrl@showHidden');

#----------- select - dependent dropdown ----------------items
Route::post('dashboard/getSelected/data', 'backend\itemCtrl@selectedData');
#----------- select - dependent dropdown ----------------items
#items-------------------------------------------------------------#items


###============================ Orders=============================###

#Orders-------------------------------------------------------BACK END
Route::get('dashboard/orders' , 'backend\orderCtrl@index');
Route::get('dashboard/orders/new' , 'backend\orderCtrl@new');
Route::get('dashboard/orders/pending' , 'backend\orderCtrl@pending');
Route::get('dashboard/orders/completed' , 'backend\orderCtrl@completed');
Route::get('dashboard/orders/returned' , 'backend\orderCtrl@returned');
Route::get('dashboard/orders/detail/{orderNo}' , 'backend\orderCtrl@viewOrderDetails');

Route::post('dashboard/orders/delete/{orderNo}' , 'backend\orderCtrl@delete');
Route::post('dashboard/orders/return/{orderNo}' , 'backend\orderCtrl@return');
Route::post('dashboard/orders/new/status/{orderNo}' , 'backend\orderCtrl@newstatus');
#-------------------------- TO shipper------------------------------
Route::get('dashboard/shipper' ,"backend\OrderCtrl@shipperIndex");
Route::get('dashboard/orders/detailToShipper/{orderNo}' , 'backend\orderCtrl@OrderDetailsToShipper');
Route::get('dashboard/orders/ToShip' , 'backend\orderCtrl@ToShip');
Route::get('dashboard/orders/detailToShip/{orderNo}' , 'backend\orderCtrl@viewOrderDetailsToShip');


#-------------------------- TO shipper------------------------------



Route::get('invoice', function () {
    return view('frontend.orders.invoice');
});
//

###============================ END Orders=============================###
#Sales------------------------------------------------------------------
Route::get('dashboard/sales' , 'backend\saleCtrl@index');
Route::get('dashboard/sales/create' , 'backend\saleCtrl@create');
Route::post('dashboard/sales/create' , 'backend\saleCtrl@store');
Route::get('dashboard/sales/edit/{saleNo}' , 'backend\saleCtrl@edit');
Route::post('dashboard/sales/edit/{saleNo}' , 'backend\saleCtrl@update');
Route::post('dashboard/sales/destroy/{saleNo}' , 'backend\saleCtrl@destroy');


Route::post('dashboard/itemSelected/data', 'backend\saleCtrl@itemSelected');

#Sales------------------------------------------------------------------
#silder------------------------------------------------------
Route::get('dashboard/slides' ,'backend\SlideCtrl@index' );
Route::get('dashboard/slides/create' ,'backend\SlideCtrl@create' );
Route::post('dashboard/slides/create' ,'backend\SlideCtrl@store' );
Route::get('dashboard/slides/edit/{id}' ,'backend\SlideCtrl@edit' );
Route::post('dashboard/slides/edit/{id}' ,'backend\SlideCtrl@update' );
Route::post('dashboard/slides/destroy/{id}' ,'backend\SlideCtrl@destroy' );
#slider--------------------------------------------------------------------

#fq-----------------------------------------------------------------------
Route::get('dashboard/fq' ,'backend\fqCtr@index' );
Route::get('dashboard/fq/create' ,'backend\fqCtr@create' );
Route::post('dashboard/fq/create' ,'backend\fqCtr@store' );
Route::get('dashboard/fq/edit/{id}' ,'backend\fqCtr@edit' );
Route::post('dashboard/fq/edit/{id}' ,'backend\fqCtr@update' );
Route::post('dashboard/fq/destroy/{id}' ,'backend\fqCtr@destroy' );
#fq-----------------------------------------------------------------------

#settings-----------------------------------------------------------------
Route::get('dashboard/settings/listURL' , 'backend\settingCtrl@URL');
Route::get('dashboard/settings/connect' , 'backend\settingCtrl@connect');
Route::get('dashboard/settings/saleName' , 'backend\settingCtrl@saleName');


Route::post('dashboard/settings/updateURL' , 'backend\settingCtrl@updateURL');
Route::post('dashboard/settings/connect' , 'backend\settingCtrl@connectUpdate');
Route::post('dashboard/settings/saleName' , 'backend\settingCtrl@saleNameUpdate');
#settings-----------------------------------------------------------------


###==============================  **   FRONT END **  ======================================================================================###
/*==============================================================================================================================================*/
/*==============================================================================================================================================*/
/*==============================================================================================================================================*/


#index frontend----------------------
Route::get('/' ,'frontend\AppCtrl@index');
#fq page
Route::get('fq', 'frontend\AppCtrl@showFq');

#Cart----------------------------------------------------------
Route::get('cart' , 'frontend\OrderCtrl@cart');
Route::post('addTocart' , 'frontend\OrderCtrl@addToCart');
Route::post('ajax/updateCart' , 'frontend\OrderCtrl@updateCart');
Route::get('cart/{id}' , 'frontend\OrderCtrl@CartDestroy');
#Cart----------------------------------------------------------

#checkOut-------------------------------------------------------FRONT END===============================================
Route::get('checkout/create'  , 'frontend\OrderCtrl@OrderCart');
Route::post('checkout/order'  , 'frontend\OrderCtrl@storeOrderCart');
// here 
Route::get('successO/{id}','frontend\OrderCtrl@invo');
#checkOut-------------------------------------------------------FRONT END

#products--------------------------------------------------------
Route::get('products' , 'frontend\productsCtrl@index');
Route::get('products/latestPage' , 'frontend\productsCtrl@latestPage');
Route::get('products/mostSold' , 'frontend\productsCtrl@mostSold');
Route::get('products/mostRated' , 'frontend\productsCtrl@mostRated');
Route::get('products/search' , 'frontend\productsCtrl@sizColor');
Route::get('products/discount' , 'frontend\productsCtrl@discount');
Route::get('products/searchPage' , 'frontend\productsCtrl@search'); //search
Route::get('products/{modelNo}' , 'frontend\productsCtrl@modelItems');
Route::get('products/details/{code}' , 'frontend\productsCtrl@productDetails');


// Route::get('products/latest' , 'frontend\productsCtrl@latest') ;
#products----------------------------------------------------------

#wishlist----------------------------------------------------------
Route::get('wishList' , 'frontend\Appctrl@wishList');
Route::post('ajax/addToWishlist',  'frontend\Appctrl@addToWishList');
Route::get('wishList/{code}' , 'frontend\Appctrl@destroy');
#wishlist----------------------------------------------------------

#stars====================================================================
Route::post('addtofeedback' , 'frontend\Appctrl@addtofeedback');
#stars====================================================================

#Comments====================================================================
Route::post('ajax/addComment' , 'frontend\Appctrl@addComment');
Route::post('ajax/removeComment' , 'frontend\Appctrl@removeComment');
#Comments====================================================================


#login & Register   ---------------------------------------------------START
#==================#
#login
Route::get('login' ,'frontend\AppCtrl@login');
Route::post('login' ,'frontend\AppCtrl@doLogin');
#-----------------------------------------------------------
#register
Route::get('register' , 'frontend\AppCtrl@register');
Route::post('register' , 'frontend\AppCtrl@doRegister');
#-----------------------------------------------------------
#logout
Route::get('logout' , 'frontend\AppCtrl@logout');
#-----------------------------------------------------------
#forget pssword
Route::get('forgetPassword' ,'frontend\AppCtrl@forgetPassword');
Route::post('forgetPassword' ,'frontend\AppCtrl@doForgetPassword');
#-----------------------------------------------------------
#change Password
Route::get('changePassword/{key}' ,'frontend\AppCtrl@changePassword');
Route::post('changePassword/{key}' ,'frontend\AppCtrl@doChangePassword');
#-----------------------------------------------------------
#login & Register   ---------------------------------------------------END
