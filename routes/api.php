<?php

Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');
Route::get('profile', 'UserController@index')->middleware('auth:api');
Route::post('profile', 'UserController@update')->middleware('auth:api');
Route::resource('video-intros', 'VideoIntroController')
    ->middleware('auth:api');
