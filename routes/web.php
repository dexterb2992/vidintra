<?php
Route::get('try', function () {
    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', 'http://topdogimsolutions.com/licensing/?pl_type=video_intro&licensekey=EFAE6C9685&domainname=localhost&email=dexterb2992@gmail.com');
   var_dump(json_decode($res->getBody()));
});
Route::get('video-intros/{videoIntro}', 'VideoIntroController@show')->name('videoIntro.show')
    ->where('videoIntro', '[0-9]+');

Route::get('/{any}', function () {
    return view('welcome');
})->where(['any' => '.*']);
