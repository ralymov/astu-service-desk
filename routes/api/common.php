<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:admin-permission'], static function () {
    Route::apiResource('users', 'User\UserController');
    Route::apiResource('user-departments', 'User\UserDepartmentController');
});
