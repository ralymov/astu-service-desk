<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketController extends ApiController
{

    public function index()
    {
        return Ticket::orderBy('id', 'desc')
            ->with('applicant_location', 'applicant', 'employee', 'type', 'priority', 'status')
            ->paginate(10);
    }

    public function show(Ticket $ticket)
    {
        return $ticket;
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
        $ticket = Ticket::create($request->all());
        return response()->json($ticket, 201);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->validate($request, [

        ]);
        $ticket->update($request->all());
        return response()->json($ticket, 200);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }

}
