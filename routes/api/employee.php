<?php

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('employees', 'Employee\EmployeeController');
    Route::post('employees/import', 'Employee\EmployeeController@import');
    Route::apiResource('positions', 'Employee\References\PositionController');
    Route::apiResource('departments', 'Employee\References\DepartmentController');
});
