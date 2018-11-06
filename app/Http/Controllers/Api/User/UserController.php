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
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = \Hash::make($request->input('password'));
        $user->role_id = Role::whereCode(Role::contractor)->first()->id;
        $user->save();
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
        ]);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->password = \Hash::make($request->input('password'));
        $user->role_id = Role::whereCode(Role::contractor)->first()->id;
        $user->save();
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

}
