<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Trait\ApiResources;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResources;



    public function login(ApiLoginRequest $apiLoginRequest)
    {
        return $this->ok($apiLoginRequest->get('email'));
    }


    public function register()
    {
        return $this->ok('register');
    }
}
