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
Route::get('autoriai', 'AppController@authors');
Route::get('autorius/{id}', 'AppController@author');
Route::get('apie-mus', 'AppController@about');

Route::get('ajax/product/{id}', 'AjaxController@product');

Route::get('scrap/cats', 'ScrapController@cats');
Route::get('scrap/authors', 'ScrapController@authors');
Route::get('scrap/products', 'ScrapController@products');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
