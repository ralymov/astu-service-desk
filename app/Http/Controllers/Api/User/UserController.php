<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\User\Role;
use App\Models\Storage\User\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function index()
    {
        return User::with('department', 'position', 'role')->orderBy('id', 'desc')->get();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'email' => 'nullable|max:255',
            'department_id' => 'nullable|integer|exists:user_departments,id',
            'position_id' => 'nullable|integer|exists:positions,id'
        ]);
        $user = new User($data);
        $user->password = \Hash::make($request->input('password'));
        $user->role_id = Role::whereCode(Role::CONTRACTOR)->first()->id;
        $user->save();
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'department_id' => 'nullable|integer|exists:user_departments,id',
            'position_id' => 'nullable|integer|exists:positions,id'
        ]);
        $user->fill($data);
        $user->password = \Hash::make($request->input('password'));
        $user->role_id = Role::whereCode(Role::CONTRACTOR)->first()->id;
        $user->save();
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

}
