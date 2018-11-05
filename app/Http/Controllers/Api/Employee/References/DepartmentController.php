<?php

namespace App\Http\Controllers\Api\Employee\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Employee\Department;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{

    public function index()
    {
        return Department::with('location')->get();
    }

    public function show(Department $department)
    {
        return $department;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $department = Department::create($request->all());
        return response()->json($department->load('location'), 201);
    }

    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $department->update($request->all());
        return response()->json($department->load('location'), 200);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(null, 204);
    }

}
