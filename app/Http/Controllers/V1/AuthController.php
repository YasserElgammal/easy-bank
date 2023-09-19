<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Api\{LoginUserRequest, RegisterUserRequest};
use App\Interfaces\AuthRepositoryInterface;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->authRepository->register($request->validated());

        return response(['success' => true, 'user' => $user]);
    }

    public function login(LoginUserRequest $request)
    {
        $user = $this->authRepository->login($request->validated());

        if (!$user) {
            return response(['success' => $user, 'message' => trans('app.authentication.invalid_login')]);
        }

        return response(['success' => true, 'user' => $user]);
    }

    public function logout()
    {
        return response(['success' => true, 'message' => $this->authRepository->logout() ? "Logged out" : "error !"]);
    }
}
