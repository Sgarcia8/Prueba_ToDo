<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // valida la solicitud
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($validateData);

        $token = $user->createToken($request->name);


        return
            [
                'user' => $user,
                'token' => $token->plainTextToken
            ];
    }

    public function login(Request $request)
    {
        // valida la solicitud
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'Mensaje' => 'Las credenciales dadas son incorrectas'
            ];
        }

        $token = $user->createToken($user->name);


        return
            [
                'user' => $user,
                'token' => $token->plainTextToken
            ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'Mensaje' => 'Saliste correctamente'
        ];
    }
}
