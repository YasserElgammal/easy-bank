<?php

namespace App\Interfaces;


interface AuthRepositoryInterface
{
    public function login(array $request);
    public function register(array $request);
    public function logout();
}
