<?php

namespace App\Repositories\V1;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\{User, Customer} ;
use Illuminate\Http\Response;

class AuthRepository implements AuthRepositoryInterface
{

    public function register($request)
    {
        $user = User::create($request);
        $user['token'] = $user->createToken('customer')->plainTextToken;
        $user->customer()->save(new Customer());

        return $user;
    }

    public function login($request)
    {
        if (!auth()->attempt($request)) {
            return ['success' => false, 'message' => trans('app.authentication.invalid_login')];
        }

        $user = auth()->user();
        $user['token'] =  auth()->user()->createToken('customer')->plainTextToken;

        return $user;
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return true;
    }
}
