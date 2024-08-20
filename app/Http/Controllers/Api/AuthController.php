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



    public function login(ApiLoginRequest $apiLoginRequest)
    {
        $apiLoginRequest->validated($apiLoginRequest->all());

        if (!Auth::attempt($apiLoginRequest->only(['email', 'password']))) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $apiLoginRequest->email);

        return $this->ok('Authenticated', [
            'user' => $user,
            'token' => $user->createToken(
                'API token for' . $user->email,
                Abilities::getAbilities($user),
                now()->addMonth()
            )
                ->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Logged out');
    }

}
