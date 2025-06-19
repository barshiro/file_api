<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return response()->json(['message' => 'Неверный логин или пароль'], 401);
        }

        $token = auth('api')->login($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users|max:50',
            'mail' => 'required|email|unique:users|max:100',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'UUID_USER' => \Str::uuid(),
            'login' => $request->login,
            'mail' => $request->mail,
            'password_hash' => Hash::make($request->password),
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Новый метод для редактирования данных пользователя
    public function update(Request $request)
    {
        $user = auth('api')->user();

        $request->validate([
            'login' => 'sometimes|string|max:50|unique:users,login,' . $user->UUID_USER . ',UUID_USER',
            'mail' => 'sometimes|email|max:100|unique:users,mail,' . $user->UUID_USER . ',UUID_USER',
            'password' => 'sometimes|string|min:6',
        ]);

        $data = [];
        if ($request->has('login')) {
            $data['login'] = $request->login;
        }
        if ($request->has('mail')) {
            $data['mail'] = $request->mail;
        }
        if ($request->has('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'user' => $user,
            'message' => 'Profile updated successfully'
        ]);
    }
}