<?php
use CM\Libs\Route;

Route::get('home','IndexController@index');
Route::post('search','SearchController@search');
Route::get('bonus','SearchController@bonus');