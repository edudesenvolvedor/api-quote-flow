<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'lastname' => 'string',
            'email' => 'email'
        ]);

        $user_id = Auth::id();
        $user = User::find($user_id);

        if(!$user) return response()->json([
            'status_code' => 404,
            'message' => 'User not found'
        ]);

        $user->update($request->all());

        return response()->json([
            'status_code' => 200,
            'message' => 'User updated successfully'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user_id = Auth::user()->getAuthIdentifier();

        $user = User::find($user_id);

        if(!Hash::check($request->input('current_password'), $user->password)) return response()->json([
            'status_code' => 401,
            'message' => 'Your current password does not matches with the password you provided. Please try again.',
        ]);

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Your password has been changed successfully.',
        ]);
    }

    public function deleteAccount(Request $request)
    {
        if(!Auth::check()) return response()->json([
            'status_code' => 401,
            'message' => 'Unauthorized'
        ]);

        $user_id = Auth::user()->getAuthIdentifier();

        $user = User::find($user_id);
        $user->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Success'
        ]);
    }
}
