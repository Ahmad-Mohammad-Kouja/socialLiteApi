<?php







Route::group(['middleware'=>'auth:api'],function () {

    Route::prefix('file')->group(function () {
        Route::post('upload', 'fileController@upload');
    });

});




