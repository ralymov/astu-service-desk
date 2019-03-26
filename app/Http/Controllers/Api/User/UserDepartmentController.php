<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\User\UserDepartment;
use Illuminate\Http\Request;

class UserDepartmentController extends ApiController
{

    public function index()
    {
        return UserDepartment::with('location')->orderBy('id', 'desc')->get();
    }

    public function show(UserDepartment $department)
    {
        return $department;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $department = UserDepartment::create($request->all());
        return response()->json($department->load('location'), 201);
    }

    public function update(Request $request, UserDepartment $department)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $department->update($request->all());
        return response()->json($department->load('location'), 200);
    }

    public function destroy(UserDepartment $department)
    {
        $department->delete();
        return response()->json(null, 204);
    }

}
