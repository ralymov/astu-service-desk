<?php


Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('tickets', 'Ticket\TicketController');
});
