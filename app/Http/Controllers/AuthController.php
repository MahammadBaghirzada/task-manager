<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Login information invalid',
            ], 401);
        }

        $user = User::query()->where('email', $validated['email'])->first();

        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:191'],
            'email' => ['required', 'email', 'unique:users', 'max:191'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::query()->create($validated);

        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }
}
