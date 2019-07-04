<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require_once __DIR__ . '/api/auth.php';
require_once __DIR__ . '/api/common.php';
require_once __DIR__ . '/api/ticket.php';
require_once __DIR__ . '/api/employee.php';
require_once __DIR__ . '/api/events.php';

Route::group(['namespace' => 'Api'], static function () {

    Route::post('search', 'Common\SearchController@index');
    Route::apiResource('locations', 'Common\LocationController');

    Route::get('/{any}', static function () {
        return response()->json(['message' => 'Not Found.'], 404);
    })->where('any', '.*');
});
