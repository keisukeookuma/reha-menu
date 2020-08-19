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
    Route::post('/toolCreate', 'RehaMenuController@toolCreate');
    Route::post('/toolDelete', 'RehaMenuController@toolDelete');
    Route::post('/changeItem', 'RehaMenuController@changeItem');
});

Route::get('/manual', 'RehaMenuController@manual');
Route::get('/opinion', 'RehaMenuController@opinion');
Route::post('/giveOpinion', 'RehaMenuController@giveOpinion');
Route::get('/opinion_show', 'RehaMenuController@opinion_show');

Route::get('/home', 'HomeController@index')->name('home');


