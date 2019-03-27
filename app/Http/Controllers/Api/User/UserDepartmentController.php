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

    public function show(UserDepartment $userDepartment)
    {
        return $userDepartment;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $department = UserDepartment::create($data);
        return response()->json($department->load('location'), 201);
    }

    public function update(Request $request, UserDepartment $userDepartment)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'nullable|integer|exists:locations,id'
        ]);
        $userDepartment->update($data);
        return response()->json($userDepartment->load('location'));
    }

    public function destroy(UserDepartment $userDepartment)
    {
        $userDepartment->delete();
        return response()->json(null, 204);
    }

}
