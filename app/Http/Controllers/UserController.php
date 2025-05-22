<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data kosong',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data user',
            'data' => $users,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_karyawan' => 'required|email|max:50|unique:users,email_karyawan',
            'nama_karyawan' => 'required|string|max:50',
            'nik_user' => 'required|integer|unique:users,nik_user',
            'role' => 'required|string|max:20',
            'password_user' => 'required|string|min:6',
            'id_gudang' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'email_karyawan' => $request->email_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'nik_user' => $request->nik_user,
            'role' => $request->role,
            'password_user' => Hash::make($request->password_user),
            'id_gudang' => $request->id_gudang,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data user ditemukan',
            'data' => $user,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'email_karyawan' => 'required|email|max:50|unique:users,email_karyawan,' . $id . ',id_user',
            'nama_karyawan' => 'required|string|max:50',
            'nik_user' => 'required|integer|unique:users,nik_user,' . $id . ',id_user',
            'role' => 'required|string|max:20',
            'password_user' => 'nullable|string|min:6',
            'id_gudang' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $user->email_karyawan = $request->email_karyawan;
        $user->nama_karyawan = $request->nama_karyawan;
        $user->nik_user = $request->nik_user;
        $user->role = $request->role;
        $user->id_gudang = $request->id_gudang;

        if ($request->filled('password_user')) {
            $user->password_user = Hash::make($request->password_user);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diupdate',
            'data' => $user,
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus',
        ], 200);
    }
}