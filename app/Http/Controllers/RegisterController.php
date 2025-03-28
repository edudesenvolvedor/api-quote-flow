<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'email_verified_at' => now(),
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(10),
        ]);

        if (!$user) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error creating user',
            ], 500);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'status_code' => 200,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('token')->plainTextToken,
            ],
        ]);
    }
}
