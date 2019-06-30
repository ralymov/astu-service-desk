<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Event;
use Illuminate\Http\Request;

class EventController extends ApiController
{

    public function index()
    {
        return Event::orderBy('date')->paginate(15);
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'date' => 'required|date',
            'computers_number' => 'required|integer|min:1',
            'computers' => 'nullable|array',
            'software' => 'nullable|array',
            'real_time' => 'nullable|numeric|min:0',
        ]);
        $event = Event::create($data);
        return response()->json($event, 201);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validate($request, [
            'name' => 'sometimes|required|max:255',
            'date' => 'sometimes|required|date',
            'computers_number' => 'sometimes|required|integer|min:1',
            'computers' => 'sometimes|nullable|array',
            'software' => 'sometimes|nullable|array',
            'real_time' => 'nullable|numeric|min:0',
        ]);
        $event->update($data);
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }

    public function calculateInstallationTime(int $eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->estimated_time = round($event->calculateInstallationTime(), 2);
        $event->save();
        return response()->json($event);
    }

}
