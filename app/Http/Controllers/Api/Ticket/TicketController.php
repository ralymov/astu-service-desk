<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Comment;
use App\Models\Storage\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketController extends ApiController
{

    public function index()
    {
        return Ticket::orderBy('id', 'desc')
            ->forList()
            ->forRole()
            ->paginate(10);
    }

    public function show(Ticket $ticket)
    {
        return $ticket->forList();
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'applicant_name' => 'nullable|max:255',
            'applicant_id' => 'nullable|integer|exists:employees,id',
            'contractor_id' => 'nullable|integer|exists:users,id',
            'department_id' => 'nullable|integer|exists:user_departments,id',
            'type_id' => 'nullable|integer|exists:ticket_types,id',
            'priority_id' => 'nullable|integer|exists:ticket_priorities,id',
            'status_id' => 'nullable|integer|exists:ticket_statuses,id',
            'comment' => 'nullable|max:1000',
            'closed_at' => 'nullable|date',
        ]);
        $ticket = Ticket::create($data);
        return response()->json($ticket->forList(), 201);
    }

    public function edit(Ticket $ticket)
    {
        return $ticket->forEdit();
    }

    public function update(Request $request, Ticket $ticket)
    {
        $data = $this->validate($request, [
            'title' => 'sometimes|required|max:255',
            'description' => 'sometimes|required|max:1000',
            'applicant_name' => 'nullable|max:255',
            'applicant_id' => 'nullable|integer|exists:employees,id',
            'contractor_id' => 'nullable|integer|exists:users,id',
            'department_id' => 'nullable|integer|exists:user_departments,id',
            'type_id' => 'nullable|integer|exists:ticket_types,id',
            'priority_id' => 'nullable|integer|exists:ticket_priorities,id',
            'status_id' => 'nullable|integer|exists:ticket_statuses,id',
            'comment' => 'nullable|max:1000',
            'closed_at' => 'nullable|date',
        ]);
        $ticket->update($data);
        return response()->json($ticket->forEdit());
    }

    public function complete(int $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->complete();
        $ticket->save();
        return response()->json($ticket->forList());
    }

    public function cancelComplete(int $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->cancelComplete();
        $ticket->save();
        return response()->json($ticket->forList());
    }

    public function lock(int $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->lock();
        $ticket->save();
        return response()->json($ticket->forList());
    }

    public function unlock(int $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->unlock();
        $ticket->save();
        return response()->json($ticket->forList());
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }

}
