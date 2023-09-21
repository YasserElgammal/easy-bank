<?php

namespace App\Repositories\V1;

use App\Enums\V1\RoleType;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\{User, Customer};
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{

    public function register($request)
    {
        $user = User::create($request);

        $user['token'] = $user->createToken(RoleType::CUSTOMER->value,
         [RoleType::CUSTOMER->value])->plainTextToken;

        if (request('avatar')) {
            $getFile = request('avatar')->store('images/customers');
            $avatar = $getFile;
        }

        $user->customer()->save(new Customer([
            'account_number' => Str::password(10, false, true, false, false),
            'dob'  => $request['dob'],
            'city'  => $request['city'],
            'phone' => $request['phone'],
            'balance' => $request['balance'],
            'avatar' => $avatar ?? null,
        ]));

        return $user;
    }

    public function login($request)
    {
        if (!auth()->attempt($request)) {
            $user = false;
            return $user;
        }

        $user = auth()->user();

        switch ($user->role_type) {
            case RoleType::ADMIN->value:
                $tokenName = RoleType::ADMIN->value;
                break;
            case RoleType::CUSTOMER->value:
                $tokenName = RoleType::CUSTOMER->value;
                break;
            case RoleType::EMPLOYEE->value:
                $tokenName = RoleType::EMPLOYEE->value;
                break;
            default:
                $tokenName = RoleType::CUSTOMER->value;
                break;
        }

        $user['token'] =  auth()->user()->createToken($tokenName, [$tokenName])->plainTextToken;

        return $user;
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return true;
    }
}
