<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Permissions\V1\Abilities;
use App\Trait\ApiResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResources;

/**
 *Login
 *
 * Auhtenticates th user and returns the user's API token.
 *
 *
 *
 * @unauthenticated
 * @group Authentication
 * @response 200 {
 * "data": {
        "user": {
            "id": 1,
            "name": "Flavie Adams",
            "email": "rgottlieb@example.net",
            "email_verified_at": "2024-08-20T13:04:22.000000Z",
            "is_manager": false,
            "created_at": "2024-08-20T13:04:23.000000Z",
            "updated_at": "2024-08-20T13:04:23.000000Z"
        },
        "token": "{YOUR_AUTH_KEY}"
    },
    "message": "Authenticated",
    "status ": 200
 * }
 */

    public function login(ApiLoginRequest $apiLoginRequest)
    {

        if (!Auth::attempt($apiLoginRequest->only(['email', 'password']))) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $apiLoginRequest->email);

        return $this->ok('Authenticated', [
            'user' => $user,
            'token' => $user->createToken(
                'API token for ' . $user->email,
                Abilities::getAbilities($user),
                now()->addMonth()
            )
                ->plainTextToken,
        ]);
    }

    /**
 *Logout
 *
 * Signs out the user and destroy's the API token.
 *
 *
 *
 * @group Authentication
 * @response 200 {}
 */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Logged out');
    }

}
