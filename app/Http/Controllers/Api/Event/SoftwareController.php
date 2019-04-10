<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Program;
use Illuminate\Http\Request;

class SoftwareController extends ApiController
{

    public function index()
    {
        return Program::orderBy('id', 'desc')->paginate(15);
    }

    public function show(Program $program)
    {
        return $program;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $program = Program::create($data);
        return response()->json($program, 201);
    }

    public function update(Request $request, Program $program)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $program->update($data);
        return response()->json($program);
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return response()->json(null, 204);
    }

}
