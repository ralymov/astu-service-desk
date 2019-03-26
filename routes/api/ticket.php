<?php

Route::group(['namespace' => 'Api'], function () {
    Route::resource('tickets', 'Ticket\TicketController');
    Route::apiResource('ticketTypes', 'Ticket\References\TicketTypeController');
    Route::apiResource('ticketPriorities', 'Ticket\References\TicketPriorityController');
    Route::apiResource('ticketStatuses', 'Ticket\References\TicketStatusController');
    Route::apiResource('ticketComments', 'Ticket\TicketCommentController');
});
