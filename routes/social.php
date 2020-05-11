<?php



Route::group(['middleware'=>'auth:api'],function () {

    Route::prefix('comments')->group(function () {
        Route::post('create', 'CommentController@add');
        Route::post('update', 'CommentController@update');
        Route::post('delete', 'CommentController@delete');
    });

    Route::prefix('posts')->group(function () {
        Route::post('create', 'PostController@create');
        Route::get('get', 'PostController@get');
        Route::post('update', 'PostController@update');
        Route::post('delete', 'PostController@delete');
    });

    Route::prefix('reactions')->group(function () {
        Route::post('react', 'ReactionController@react');
    });

});






