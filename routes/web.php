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

Route::get('scrap/make-authors-fullnames', 'ScrapController@makeAuthorsFullnames');

Route::get('autoriai', 'AppController@authors');
Route::get('autorius/{author}', 'AppController@author');
Route::get('apie-mus', 'AppController@about');

Route::get('ajax/modal/{id}', 'AjaxController@modal');
Route::post('ajax/load-more', 'AjaxController@loadMore');

Route::get('{cat}', 'AppController@category');
Route::get('{cat}/{product}', 'AppController@product');

// Function for fixing broken links with 3 segments
Route::get('{url1}/{url2}/{url3}', 'AppController@url');
