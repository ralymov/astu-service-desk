<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Processor;
use Illuminate\Http\Request;

class ProcessorController extends ApiController
{

    public function index()
    {
        return Processor::orderBy('id','desc')->paginate(15);
    }

    public function show(Processor $processor)
    {
        return $processor;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'processors_number' => 'required|integer|min:1',
            'frequency' => 'required|integer|min:1',
        ]);
        $processor = Processor::create($data);
        return response()->json($processor, 201);
    }

    public function update(Request $request, Processor $processor)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'processors_number' => 'required|integer|min:1',
            'frequency' => 'required|integer|min:1',
        ]);
        $processor->update($data);
        return response()->json($processor);
    }

    public function destroy(Processor $processor)
    {
        $processor->delete();
        return response()->json(null, 204);
    }

}
