<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $token = Auth::login($user);
        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return false;
        }

        return [
            'user'  => Auth::user(),
            'token' => $token,
        ];
    }

    public function logout()
    {
        Auth::logout();
    }

    public function refresh()
    {
        $token = Auth::refresh();
        return [
            'user'  => Auth::user(),
            'token' => $token,
        ];
    }

    public function me()
    {
        return Auth::user();
    }
}
