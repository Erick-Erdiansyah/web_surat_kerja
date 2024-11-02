<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Revoke the user's current token
        $user->currentAccessToken()->delete();

        // Optionally, you can also log out from all devices
        // $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
