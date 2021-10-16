<?php
use CM\Core\Route;

Route::get('home','IndexController@index');
Route::post('home','IndexController@index');
Route::post('search','SearchController@search')->name('search');
Route::get('bonus','SearchController@bonus')->name('hehe');
Route::get('hehe','SearchController@hehe2','TestMiddleware');
Route::post('hehesse/{id}/{c_id}','SearchController@hehe')->name('test');
Route::get('abs/{id}/haha/{c_id}','SearchController@tesst2')->name('abb');
