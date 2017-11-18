<?php

Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');
// Route::post('password/reset', '');

Route::resource('video-intros', 'VideoIntroController')
    ->middleware('auth:api');
