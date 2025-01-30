<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function register(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('token_app')->plainTextToken;

        $response = [
            'status' => true,
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    function login(Request $request)
    {
        try {
            $fields = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
            ], 422);
        }

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $token = $user->createToken('token_app')->plainTextToken;

        $response = [
            'status' => true,
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Token deleted'
        ], 201);
    }
}
