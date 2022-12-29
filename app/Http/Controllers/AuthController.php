<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $fields = $req->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users, email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('TOKEN-HERE')->plainTextToken;

        $resp = [
            'user' => $user,
            'token' => $token,
            'msg' => 'Register Success!',
        ];

        return Response($resp, 201);
    }

    public function login(Request $req) {
        $fields = $req->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();
        
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return Response([
                'msg' => 'email or password Wrong!',
            ], 401);
        }

        $token = $user->createToken('TOKEN-HERE')->plainTextToken;

        $resp = [
            'user' => $user,
            'token' => $token,
            'msg' => 'Logged In!',
        ];

        return Response($resp, 201);
    }

    public function logout(Request $req) 
    {
        auth()->user()->tokens()->delete();

        return [
            'msg' => 'Logged Out!',
        ];
    }
}
