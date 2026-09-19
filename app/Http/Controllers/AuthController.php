<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
            'telefono'            => 'nullable|string|max:20',
            'fecha_nacimiento'    => 'nullable|date',
            'documento_identidad' => 'nullable|string|max:30|unique:users,documento_identidad',
        ]);

        $user = User::create([
            'name'                => $data['name'],
            'email'               => $data['email'],
            'password'            => Hash::make($data['password']),
            'telefono'            => $data['telefono'] ?? null,
            'fecha_nacimiento'    => $data['fecha_nacimiento'] ?? null,
            'documento_identidad' => $data['documento_identidad'] ?? null,
        ]);

        $user->assignRole('paciente');

        return response()->json([
            'message' => 'Usuario registrado correctamente.',
            'user'    => $user->load('roles'),
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'token'   => $token,
            'user'    => $user->load('roles'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada.']);
    }
}