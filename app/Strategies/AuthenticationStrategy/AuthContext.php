<?php

namespace App\Strategies\AuthenticationStrategy;

use App\Models\User;

class AuthContext
{
    private AuthStrategy $strategy;

    /**
     * Set the authentication strategy.
     *
     * @param AuthStrategy $strategy
     */
    public function setStrategy(AuthStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * Delegate the register process to the current strategy.
     *
     * @param array $data
     * @return User|null
     */
    public function register(array $data): ?User
    {
        return $this->strategy->register($data);
    }

    /**
     * Delegate the login process to the current strategy.
     *
     * @param array $credentials
     * @return User|null
     */
    public function login(array $credentials): ?User
    {
        return $this->strategy->login($credentials);
    }
}
