<?php




Route::post('register','UserController@register');

Route::post('login','UserController@login');

Route::post('socialLogin','UserController@socialLogin');


Route::group(['middleware'=>'auth:api'],function () {
    Route::prefix('user')->group(function () {
        Route::post('profile', 'UserController@profile');
    });
});










