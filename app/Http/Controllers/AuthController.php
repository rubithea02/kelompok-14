<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

        // Hapus token lama terlebih dahulu jika perlu (opsional)
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        // Pastikan ada token yang valid
        if ($request->user()?->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada token yang aktif',
        ], 401);
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }
}