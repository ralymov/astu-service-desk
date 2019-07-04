<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:basic-permission'], static function () {
    Route::resource('tickets', 'Ticket\TicketController');
    Route::apiResource('ticketComments', 'Ticket\TicketCommentController');

    Route::apiResource('ticketTypes', 'Ticket\References\TicketTypeController', ['only' => ['index']]);
    Route::apiResource('ticketTypes', 'Ticket\References\TicketTypeController', ['except' => ['index']])
        ->middleware('can:admin-permission');

    Route::apiResource('ticketPriorities', 'Ticket\References\TicketPriorityController', ['only' => ['index']]);
    Route::apiResource('ticketPriorities', 'Ticket\References\TicketPriorityController', ['except' => ['index']])
        ->middleware('can:admin-permission');

    Route::apiResource('ticketStatuses', 'Ticket\References\TicketStatusController', ['only' => ['index']]);
    Route::apiResource('ticketStatuses', 'Ticket\References\TicketStatusController', ['except' => ['index']])
        ->middleware('can:admin-permission');

});
