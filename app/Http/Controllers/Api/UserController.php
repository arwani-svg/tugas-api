<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // tampil semua user
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    // tampil 1 user (hanya boleh milik sendiri, dicek middleware user.owner)
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json($user);
    }

    // edit user (hanya boleh milik sendiri)
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->email) {
            $user->email = $request->email;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
    }

    // hapus user (hanya boleh milik sendiri)
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

    // tampil buku-buku milik user tertentu
    // contoh: GET /api/users/1/bukus
    // kalau id nya bukan milik sendiri, ditolak 403
    public function bukus(Request $request, $userId)
    {
        if ($userId != $request->user()->id) {
            return response()->json([
                'message' => 'Tidak bisa lihat buku milik user lain'
            ], 403);
        }

        $user = User::find($userId);

        return response()->json($user->bukus);
    }
}
