<?php

Route::get('video-intros/{videoIntro}', 'VideoIntroController@show')->name('videoIntro.show');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
