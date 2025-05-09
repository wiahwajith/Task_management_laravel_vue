<?php

namespace App\Http\Controllers\API;

use App\Traits\ApiResponser;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponser;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->handleAction(function () use ($request) {

            $result = $this->authService->register($request->all());
            return $this->successResponse($result, 'User registered successfully', 201);
        }, 'Failed to register user');
    }

    public function login(LoginRequest $request)
    {
        return $this->handleAction(function () use ($request) {

            $result = $this->authService->login($request->all());

            if (!$result) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            return $this->successResponse($result, 'Login successful');
        }, 'Failed to log in');
    }

    public function logout()
    {
        return $this->handleAction(function () {
            $this->authService->logout();
            return $this->successResponse(null, 'Logged out successfully');
        });
    }

    public function refresh()
    {
        return $this->handleAction(function () {
            return $this->successResponse($this->authService->refresh(), 'Token refreshed');
        });
    }

    public function me()
    {
        return $this->handleAction(function () {
            return $this->successResponse($this->authService->me(), 'User info fetched');
        });
    }
}
