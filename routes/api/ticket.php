<?php

Route::group(['namespace' => 'Api', 'middleware' => 'can:basic-permission'], static function () {
    Route::resource('tickets', 'Ticket\TicketController');
    Route::get('tickets/lock/{ticketId}', 'Ticket\TicketController@lock');
    Route::get('tickets/unlock/{ticketId}', 'Ticket\TicketController@unlock');
    Route::get('tickets/complete/{ticketId}', 'Ticket\TicketController@complete');
    Route::get('tickets/cancel-complete/{ticketId}', 'Ticket\TicketController@cancelComplete');
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
