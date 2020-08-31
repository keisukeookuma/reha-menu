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
Auth::routes();


Route::get('/', 'RehaMenuController@top');
Route::get('/index', 'RehaMenuController@index');
Route::post('/ajax', 'RehaMenuController@getData');

Route::group(['middleware' => 'auth'],function(){
    Route::get('/tool', 'RehaMenuController@tool');
    Route::post('/createItem', 'RehaMenuController@createItem');
    Route::post('/deleteItem', 'RehaMenuController@deleteItem');
    Route::post('/changeItem', 'RehaMenuController@changeItem');
    Route::post('/createTemplate', 'RehaMenuController@createTemplate');
    Route::post('/deleteTemplate', 'RehaMenuController@deleteTemplate');
});

Route::get('/manual', 'RehaMenuController@manual');
Route::get('/opinion', 'RehaMenuController@opinion');
Route::post('/giveOpinion', 'RehaMenuController@giveOpinion');
Route::get('/opinionShow', 'RehaMenuController@opinionShow');

Route::get('/home', 'HomeController@index')->name('home');


