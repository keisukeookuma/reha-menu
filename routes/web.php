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


Route::get('/', 'TopController@top');
Route::get('/index', 'IndexController@index');
Route::post('/ajax', 'IndexController@getData');

Route::group(['middleware' => 'auth'],function(){
    Route::get('/tool', 'ToolController@tool');
    Route::post('/createItem', 'ToolController@createItem');
    Route::post('/deleteItem', 'ToolController@deleteItem');
    Route::post('/changeItem', 'ToolController@changeItem');
    Route::post('/createTemplate', 'ToolController@createTemplate');
    Route::post('/deleteTemplate', 'ToolController@deleteTemplate');
    Route::get('/opinionShow', 'OpinionController@opinionShow');
    Route::get('/userList', 'UserListController@userListShow');
});

Route::get('/manual', 'ManualController@manual');
Route::get('/opinion', 'OpinionController@opinion');
Route::post('/giveOpinion', 'OpinionController@giveOpinion');

Route::get('/terms', 'TermsController@terms');
Route::get('/contact', 'ContactController@contact');

Route::get('/home', 'HomeController@index')->name('home');


