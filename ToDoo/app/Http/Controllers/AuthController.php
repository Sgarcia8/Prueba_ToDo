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

        $user = User::create($validateData); // Si la información cumple con los requisitos se crea un nuevo usuario

        $token = $user->createToken($request->name); // Se crea el token de acceso


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

        $user = User::where('email', $request->email)->first(); //Si la información es valida devuelve el primer usuario encontrado por el email(campo unico)

        if (!$user || !Hash::check($request->password, $user->password)) { //Verifica que las contraseñas coincidan
            return [
                'Mensaje' => 'Las credenciales dadas son incorrectas'
            ];
        }

        $token = $user->createToken($user->name); //Crea un token de acceso


        return
            [
                'user' => $user,
                'token' => $token->plainTextToken
            ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); //Elimina los token de acceso de la base de datos creados para el usuario

        return [
            'Mensaje' => 'Saliste correctamente'
        ];
    }
}
