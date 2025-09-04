<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'satker' => 'required|string',
            'nip' => 'required|string|max:18|unique:users',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        // Simpan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'satker' => $request->satker,
            'nip' => $request->nip,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password), // password di-hash
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('nip', 'password'))) {
            return response()->json([
                'message' => 'NIP atau password salah'
            ], 401);
        }

        $user = Auth::user();

        // bikin token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

}
