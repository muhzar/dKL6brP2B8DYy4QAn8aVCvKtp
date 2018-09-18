<?php

// use Illuminate\Http\Request;

Route::post('v1/login', 'Frontend\LoginController@index');
Route::get('v1/login', 'Frontend\LoginController@index');
