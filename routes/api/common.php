<?php

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('users', 'User\UserController');
});
