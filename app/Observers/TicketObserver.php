<?php

namespace App\Observers;

use App\Models\Storage\Ticket\Ticket;
use App\Models\Storage\Ticket\TicketHistory;

class TicketObserver
{
    /**
     * Handle the ticket "created" event.
     *
     * @param Ticket $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'author_id' => auth()->user()->id,
            'description' => 'Заявка была создана'
        ]);
    }

    /**
     * Handle the ticket "updated" event.
     *
     * @param Ticket $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        //
    }
}
