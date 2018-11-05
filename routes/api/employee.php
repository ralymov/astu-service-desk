<?php

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('positions', 'Employee\References\PositionController');
    Route::apiResource('departments', 'Employee\References\DepartmentController');
});
