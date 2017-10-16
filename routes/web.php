<?php
Route::get('video-intros/{videoIntro}', 'VideoIntroController@show')->name('videoIntro.show')
    ->where('videoIntro', '[0-9]+');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
