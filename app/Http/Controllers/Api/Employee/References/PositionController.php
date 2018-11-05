<?php

namespace App\Http\Controllers\Api\Employee\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Employee\Position;
use Illuminate\Http\Request;

class PositionController extends ApiController
{

    public function index()
    {
        return Position::all();
    }

    public function show(Position $positions)
    {
        return $positions;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $position = Position::create($request->all());
        return response()->json($position, 201);
    }

    public function update(Request $request, Position $position)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $position->update($request->all());
        return response()->json($position, 200);
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return response()->json(null, 204);
    }

}
