<?php

namespace App\Http\Controllers\Api\Ticket\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\References\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends ApiController
{

    public function index()
    {
        return TicketType::orderBy('id', 'desc')->get();
    }

    public function show(TicketType $ticketType)
    {
        return $ticketType;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $ticketType = TicketType::create($request->all());
        return response()->json($ticketType, 201);
    }

    public function update(Request $request, TicketType $ticketType)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $ticketType->update($request->all());
        return response()->json($ticketType, 200);
    }

    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();
        return response()->json(null, 204);
    }

}
