<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Comment;
use App\Models\Storage\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketCommentController extends ApiController
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|max:1000',
            'ticket_id' => 'required|integer|exists:tickets,id',
        ]);
        $comment = Comment::create($request->only('text'));
        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->comments()->attach($comment->id);
        return response()->json($comment->load('author'), 201);
    }


    public function destroy(Comment $ticketComment)
    {
        $ticketComment->delete();
        return response()->json(null, 204);
    }

}
