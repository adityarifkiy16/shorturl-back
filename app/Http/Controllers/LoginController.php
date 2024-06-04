<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $credentials = $request->validate($rules, $customMessages);

        if (!$token = Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['messages' => 'successfully logged out'], 200);
    }
}
