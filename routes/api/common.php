<?php

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('users', 'User\UserController');
    Route::apiResource('user-departments', 'User\UserDepartmentController');
});
