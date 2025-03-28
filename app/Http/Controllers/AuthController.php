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
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        if(!$user) return response()->json([
            'status_code' => 401,
            'message' => 'Unauthorized'
        ]);

        $user->tokens()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Logged out'
        ]);
    }

    public function refresh()
    {
        $user = Auth::user();

        if(!$user) return response()->json([
            'status_code' => 401,
            'message' => 'Unauthorized'
        ]);
        return response()->json([
            'status_code' => 200,
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }

    public function me(Request $request)
    {
        if(!Auth::check()) return response()->json([
            'status_code' => 401,
            'message' => 'Unauthorized'
        ]);

        return response()->json([
            'status_code' => 200,
            'data' => $request->user()
        ]);
    }
}
