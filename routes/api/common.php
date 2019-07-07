<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:basic-permission'], static function () {
    Route::apiResource('users', 'User\UserController', ['only' => ['index']]);
    Route::apiResource('users', 'User\UserController', ['except' => ['index']])
        ->middleware('can:admin-permission');

    Route::apiResource('user-departments', 'User\UserDepartmentController', ['only' => ['index']]);
    Route::apiResource('user-departments', 'User\UserDepartmentController', ['except' => ['index']])
        ->middleware('can:admin-permission');
});
