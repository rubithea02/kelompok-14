<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login API
    public function login(Request $request)
    {
        $request->validate([
            'email_karyawan' => 'required|email',
            'password_user' => 'required|string',
        ]);

        $user = User::where('email_karyawan', $request->email_karyawan)->first();

        if (! $user || ! Hash::check($request->password_user, $user->password_user)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Login secara manual
        Auth::login($user);

        // Hapus token lama jika ada
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }

    // Logout API
    public function logout(Request $request)
    {
        if ($request->user()?->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    // Ambil user yang sedang login
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }
}