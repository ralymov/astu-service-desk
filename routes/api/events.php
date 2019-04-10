<?php

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('events', 'Event\EventController');
    Route::apiResource('processors', 'Event\ProcessorController');
    Route::apiResource('ram', 'Event\RamController');
    Route::apiResource('programs', 'Event\SoftwareController');
});
