<?php

namespace App\Strategies\AuthenticationStrategy;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StandardAuthStrategy implements AuthStrategy
{
    public function register(array $data): ?User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::USER,
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        return $user;
    }

    public function login(array $credentials): ?User
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Auth::attempt($credentials)) {
            return null;
        }

        return $user;
    }
}
