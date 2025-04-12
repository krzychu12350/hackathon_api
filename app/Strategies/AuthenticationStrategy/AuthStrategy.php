<?php

namespace App\Strategies\AuthenticationStrategy;

use App\Models\User;

interface AuthStrategy
{
    public function register(array $data): ?User;
    public function login(array $credentials): ?User;
}