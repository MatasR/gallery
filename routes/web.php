<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'AppController@home');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('autoriai', 'AppController@authors');
Route::get('autorius/{author}', 'AppController@author');
Route::get('apie-mus', 'AppController@about');

Route::get('ajax/modal/{id}', 'AjaxController@modal');
Route::post('ajax/load-more', 'AjaxController@loadMore');

Route::get('{cat}', 'AppController@category');
Route::get('{cat}/{product}', 'AppController@product');

/*Route::get('scrap/make-slugs', 'ScrapController@makeSlugs');
Route::get('scrap/make-thumbs', 'ScrapController@makeThumbs');
Route::get('scrap/convert-name', 'ScrapController@convertName');
Route::get('scrap/products', 'ScrapController@getProducts');
Route::get('scrap/import', 'ScrapController@import');
Route::get('scrap/importproducts', 'ScrapController@importProducts');
Route::get('scrap/getProducts', 'ScrapController@getProducts');
Route::get('scrap/importauthorproducts','ScrapController@importAuthorProducts');*/

Route::get('/welcome', function () {
    return view('welcome');
});
