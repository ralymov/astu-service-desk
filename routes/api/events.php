<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:basic-permission'], static function () {
    Route::apiResource('events', 'Event\EventController');
    Route::post('events/{id}/calculate', 'Event\EventController@calculateInstallationTime');
    Route::apiResource('processors', 'Event\ProcessorController');
    Route::apiResource('ram', 'Event\RamController');
    Route::apiResource('programs', 'Event\SoftwareController');
});
