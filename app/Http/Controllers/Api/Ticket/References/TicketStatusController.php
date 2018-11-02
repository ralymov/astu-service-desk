<?php

namespace App\Http\Controllers\Api\Ticket\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\References\TicketStatus;
use Illuminate\Http\Request;

class TicketStatusController extends ApiController
{

    public function index()
    {
        return TicketStatus::all();
    }

    public function show(TicketStatus $ticketStatus)
    {
        return $ticketStatus;
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
        $ticketStatus = TicketStatus::create($request->all());
        return response()->json($ticketStatus, 201);
    }

    public function update(Request $request, TicketStatus $ticketStatus)
    {
        $this->validate($request, [

        ]);
        $ticketStatus->update($request->all());
        return response()->json($ticketStatus, 200);
    }

    public function destroy(TicketStatus $ticketStatus)
    {
        $ticketStatus->delete();
        return response()->json(null, 204);
    }

}
