<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\User\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function index()
    {
        return User::with('department', 'position', 'role')->orderBy('id', 'desc')->get();
    }

    public function show(User $users)
    {
        return $users;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'position_id' => 'nullable|integer|exists:positions,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ]);
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'position_id' => 'nullable|integer|exists:positions,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ]);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

}
