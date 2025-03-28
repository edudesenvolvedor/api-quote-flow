<?php

namespace App\Http\Controllers;

use App\Jobs\SendResetLinkEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => trans($response)
            ], 200);
        }

        return response()->json([
            'message' => trans($response)
        ], 400);
    }

    public function resetPassword(Request $request)
    {

    }
}
