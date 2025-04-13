<?php

namespace App\Http\Controllers;

use App\Enums\BanType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SocialLoginRequest;
use App\Http\Requests\Auth\SocialRegisterRequest;
use App\Models\User;
use App\Strategies\AuthenticationStrategy\AuthStrategy;
use App\Strategies\AuthenticationStrategy\StandardAuthStrategy;
use App\Strategies\AuthenticationStrategy\SocialAuthStrategy;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthStrategy $authStrategy;

    /**
     * Inject a default strategy (StandardAuthStrategy).
     */
    public function __construct(AuthStrategy $authStrategy = null)
    {
        $this->authStrategy = $authStrategy ?? new StandardAuthStrategy();
    }

    /**
     * Dynamically set the authentication strategy.
     */
    protected function setStrategy(array $data): void
    {
        if (isset($data['provider'])) {
            $this->authStrategy = new SocialAuthStrategy();
        } else {
            $this->authStrategy = new StandardAuthStrategy();
        }
    }

    /**
     * Resolve the appropriate request class for registration.
     */
    protected function resolveRegisterRequest(Request $request)
    {
        return isset($request->provider)
            ? app(SocialRegisterRequest::class)
            : app(RegisterRequest::class);
    }

    /**
     * Resolve the appropriate request class for login.
     */
    protected function resolveLoginRequest(Request $request)
    {
        return isset($request->provider)
            ? app(SocialLoginRequest::class)
            : app(LoginRequest::class);
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $formRequest = $this->resolveRegisterRequest($request);
        $data = $formRequest->validated();
        $this->setStrategy($data);

        try {
            $user = $this->authStrategy->register($data);
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $formRequest = $this->resolveLoginRequest($request);
        $credentials = $formRequest->validated();

        $this->setStrategy($credentials);

        try {
            $user = $this->authStrategy->login($credentials);

            if(!$user) {
                return $this->error('Wrong credentials', 422);
            }

            return $this->success([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
