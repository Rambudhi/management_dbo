<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResources;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use JWTAuth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::guard()->attempt($credentials);

        return (new UserResources($request->user()))
                ->additional(['meta' => [
                    'token' => $token,
                ]]);
    }
}
