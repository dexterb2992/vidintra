<?php

Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');

Route::resource('recipes', 'RecipeController');
Route::resource('video-intros', 'VideoIntroController')
    ->middleware('auth:api');
