<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace'=>'Api'],function ()
{
  ////////////////////////////// start general apis  ///////////////

  Route::get('cities', 'MainController@cities' );
  Route::get('regions', 'MainController@regions' );
  Route::get('payment-method', 'MainController@paymentMethod' );
  Route::get('settings', 'MainController@settings' );
  Route::get('offers', 'MainController@offers' );
  Route::get('offer-details', 'MainController@offerDetails' );
  Route::get('restaurants', 'MainController@restaurants' );
  Route::get('restaurant-details', 'MainController@restaurantDetails' );
  Route::get('products', 'MainController@products' );
  Route::get('product-details', 'MainController@productDetails' );
  Route::get('categories', 'MainController@categories' );
  Route::get('reviews', 'MainController@reviews' );

  ////////////////////////////// end general apis  ///////////////

  ////////////////////////////// start AuthClient apis  ///////////////

  Route::post('client-register', 'AuthController@clientRegister' );
  Route::post('client-login', 'AuthController@clientLogin' );
  Route::post('client-reset-password', 'AuthController@clientResetPassword' );
  Route::post('client-new-password', 'AuthController@clientNewPassword' );
  Route::group(['middleware' => 'auth:client'],function ()
  {
    Route::post('client-profile', 'AuthController@clientProfile' );
    Route::post('client-register-token', 'AuthController@clientRegisterToken' );
    Route::post('client-remove-token', 'AuthController@clientRemoveToken' );
  });

  ////////////////////////////// end AuthClient apis  ///////////////

  ////////////////////////////// start  AuthRestaurant apis  ///////////////

  Route::post('restaurant-register', 'AuthController@restaurantRegister' );
  Route::post('restaurant-login', 'AuthController@restaurantLogin' );
  Route::group(['middleware' => 'auth:restaurant'],function ()
  {
    Route::post('restaurant-profile', 'AuthController@restaurantProfile' );
    Route::post('restaurant-register-token', 'AuthController@restaurantRegisterToken' );
    Route::post('restaurant-remove-token', 'AuthController@restaurantRemoveToken' );

  });
  Route::post('restaurant-reset-password', 'AuthController@restaurantResetPassword' );
  Route::post('restaurant-new-password', 'AuthController@restaurantNewPassword' );


  ////////////////////////////// end  AuthRestaurant apis  ///////////////

  ////////////////////////////// start  restarant food items apis  ///////////////

  Route::group(['middleware' => 'auth:restaurant'],function ()
  {
    Route::get('show-products', 'MainController@showProducts' );
    Route::post('create-product', 'MainController@createProduct' );
    Route::post('edit-product', 'MainController@editProduct' );
    Route::post('delete-product', 'MainController@deleteProduct' );

  });


  ////////////////////////////// end  restarant food items apis  ///////////////


  ////////////////////////////// start  restarant offers apis  ///////////////

  Route::group(['middleware' => 'auth:restaurant'],function ()
  {
    Route::get('show-offers', 'MainController@showOffers' );
    Route::post('create-offer', 'MainController@createOffer' );
    Route::post('edit-offer', 'MainController@editOffer' );
    Route::post('delete-offer', 'MainController@deleteOffer' );

  });


  ////////////////////////////// end  restarant offers apis  ///////////////


  ////////////////////////////// start client order apis  ///////////////

  Route::group(['middleware' => 'auth:client'],function ()
  {
    Route::post('new-order', 'MainController@newOrder' );
    Route::get('order-details', 'MainController@orderDetails' );
    Route::get('my-orders', 'MainController@myOrders' );
    Route::post('client-accepted-order', 'MainController@clientAcceptedOrder' );
    Route::post('client-declined-order', 'MainController@clientDeclinedOrder' );

  });

  ////////////////////////////// end client order apis  ///////////////


  ////////////////////////////// start restarant order apis  ///////////////

  Route::group(['middleware' => 'auth:restaurant'],function ()
  {

    Route::get('restaurant-orders', 'MainController@restaurantOrders' );
    Route::post('restaurant-confirm-order', 'MainController@restaurantConfirmOrder' );
    Route::post('restaurant-accepted-order', 'MainController@restaurantAcceptedOrder' );
    Route::post('restaurant-rejected-order', 'MainController@restaurantRejectedOrder' );

  });

  ////////////////////////////// end restarant order apis  ///////////////

  Route::post('contact-us', 'MainController@contactUs' );

  Route::group(['middleware' => 'auth:client'],function ()
  {
    Route::post('create-review', 'MainController@createReview' );

  });

});
