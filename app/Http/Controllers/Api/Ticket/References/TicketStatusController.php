<?php

namespace App\Http\Controllers\Api\Ticket\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\References\TicketStatus;
use Illuminate\Http\Request;

class TicketStatusController extends ApiController
{

    public function index()
    {
        return TicketStatus::orderBy('id', 'desc')->get();
    }

    public function show(TicketStatus $ticketStatus)
    {
        return $ticketStatus;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'rgb' => 'nullable|max:7',
            'code' => 'required|max:10',
        ]);
        $ticketStatus = TicketStatus::create($request->all());
        return response()->json($ticketStatus, 201);
    }

    public function update(Request $request, TicketStatus $ticketStatus)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'rgb' => 'nullable|max:7'
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
