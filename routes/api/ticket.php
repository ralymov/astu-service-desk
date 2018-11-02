<?php


Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('tickets', 'Ticket\TicketController');
    Route::apiResource('ticketTypes', 'Ticket\References\TicketTypeController');
    Route::apiResource('ticketPriorities', 'Ticket\References\TicketPriorityController');
    Route::apiResource('ticketStatuses', 'Ticket\References\TicketStatusController');
});
