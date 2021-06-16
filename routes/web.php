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

Route::get('/', ['as' => 'home',
    'uses' => 'IndexController@index']);
Route::get('/{id}-{slug}', ['as' => 'view.product',
    'uses' => 'IndexController@viewProduct']);
Route::get('/getProduct', ['as' => 'get.product',
    'uses' => 'IndexController@getProduct']);
Route::get('/newJob', ['as' => 'new.job',
    'uses' => 'IndexController@insertJob']);
Route::post('/newJob', ['as' => 'new.job',
    'uses' => 'IndexController@insertJobSave']);

Route::get('/goTo/{url}', array(
    'as' => 'go.to',
    'uses' => 'PageController@goToUrl'))->where('url', '.*');
