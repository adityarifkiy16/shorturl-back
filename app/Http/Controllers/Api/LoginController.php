<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $credentials = $request->validate($rules, $customMessages);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'code' => 200,
                'message' => 'Login Success',
                'data' => [
                    'user' => $user,
                    'token' => $user->createToken('authToken')->accessToken
                ]
            ], 200);
        }
        return response()->json([
            'code' => 401,
            'message' => 'The provided credentials do not match our records.'
        ], 401);
    }
}
