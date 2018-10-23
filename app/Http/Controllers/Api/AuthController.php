<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class AuthController extends ApiController {

    /**
     * Create a new AuthController instance.
     *
     */
    public function __construct() {
        $this->middleware('auth.api', ['except' => ['login']]);
    }

    /**
     * Login user and return the user if successful.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $credentials = $request->only(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function credentials() {
        $user = auth()->user();
        if (!$user) {
            return $this->respondUnauthorized();
        }
        return response()->json([
            'access_token' => $user->token,
            'username' => $user->username,
            'role' => $user->role->name,
            'id' => $user->id,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ])->withCookie(cookie()->forever('token', $token, null, null, null, false));
    }
}
