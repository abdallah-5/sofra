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


Route::group(['middleware' => ['auth'] , 'prefix'=>'admin','namespace'=>'Admin'],function ()
{
  Route::get('/home', 'HomeController@index')->name('home');
  Route::resource('cities','CityController');
  Route::resource('regions','RegionController');
  Route::resource('categories','CategoryController');
  Route::resource('offers','OfferController');
  Route::resource('contacts','ContactController');
  Route::resource('settings','SettingController');

  Route::resource('restaurants','RestaurantController');
  Route::get('restaurants-activate/{id}', 'RestaurantController@activate')->name('restaurants.activate');
  Route::get('restaurants-deactivate/{id}', 'RestaurantController@deactivate')->name('restaurants.deactivate');

  Route::resource('clients','ClientController');
  Route::get('clients-activate/{id}', 'ClientController@activate')->name('clients.activate');
  Route::get('clients-deactivate/{id}', 'ClientController@deactivate')->name('clients.deactivate');

  Route::resource('orders','OrderController');
  Route::resource('users','UserController');
  Route::resource('roles','RoleController');
});
