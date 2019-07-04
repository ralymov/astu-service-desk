<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:basic-permission'], static function () {
    Route::apiResource('employees', 'Employee\EmployeeController');
    Route::post('employees/import', 'Employee\EmployeeController@import');
    Route::post('employees/search', 'Employee\EmployeeController@search');
    Route::apiResource('positions', 'Employee\References\PositionController');
    Route::apiResource('departments', 'Employee\References\DepartmentController');
});
