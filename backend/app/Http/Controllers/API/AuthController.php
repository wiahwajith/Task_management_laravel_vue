<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->handleAction(function () use ($request) {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);
            $result = $this->authService->register($validated);
            return $this->successResponse($result, 'User registered successfully', 201);
        }, 'Failed to register user');
    }

    public function login(Request $request)
    {
        return $this->handleAction(function () use ($request) {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required'
            ]);
            $result = $this->authService->login($credentials);

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
