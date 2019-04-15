<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\Ram;
use Illuminate\Http\Request;

class RamController extends ApiController
{

    public function index(Request $request)
    {
        if ($request->has('page')) {
            return Ram::orderBy('id', 'desc')->paginate(15);
        }
        return Ram::orderBy('id', 'desc')->get();
    }

    public function show(Ram $ram)
    {
        return $ram;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'generation' => 'required|integer|min:1',
            'frequency' => 'required|integer|min:1',
            'memory_size' => 'required|integer|min:1',
        ]);
        $ram = Ram::create($data);
        return response()->json($ram, 201);
    }

    public function update(Request $request, Ram $ram)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'generation' => 'required|integer|min:1',
            'frequency' => 'required|integer|min:1',
            'memory_size' => 'required|integer|min:1',
        ]);
        $ram->update($data);
        return response()->json($ram);
    }

    public function destroy(Ram $ram)
    {
        $ram->delete();
        return response()->json(null, 204);
    }

}
