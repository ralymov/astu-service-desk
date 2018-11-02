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
            ->forList('applicant_location', 'applicant', 'employee', 'type', 'priority', 'status')
            ->paginate(10);
    }

    public function show(Ticket $ticket)
    {
        return $ticket;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'applicant_name' => 'nullable|max:255',
            'applicant_id' => 'nullable|integer|exists:employees,id',
            'employee_id' => 'nullable|integer|exists:employees,id',
            'type_id' => 'nullable|integer|exists:ticket_types,id',
            'priority_id' => 'nullable|integer|exists:ticket_priorities,id',
            'comment' => 'nullable|max:1000',
        ]);
        $ticket = Ticket::create($request->except('comment'));
        if ($request->has('comment')) {
            $comment = Comment::create(['text'=>$request->input('comment')]);
            $ticket->comments()->attach($comment->id);
        }
        return response()
            ->json($ticket->forList(), 201);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'applicant_name' => 'nullable|max:255',
            'applicant_id' => 'nullable|integer|exists:employees,id',
            'employee_id' => 'nullable|integer|exists:employees,id',
            'type_id' => 'nullable|integer|exists:ticket_types,id',
            'priority_id' => 'nullable|integer|exists:ticket_priorities,id',
            'comment' => 'nullable|max:1000',
        ]);
        $ticket->update($request->all());
        return response()
            ->json($ticket->forList(), 200);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }

}
