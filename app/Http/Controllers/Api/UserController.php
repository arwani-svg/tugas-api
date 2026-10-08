<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/users (auth) - list semua user
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => User::select('id', 'name', 'email', 'created_at')->get(),
        ]);
    }

    // GET /api/users/{user} (auth + user.owner) - hanya milik sendiri
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }

    // PUT /api/users/{user} (auth + user.owner)
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diupdate.',
            'data' => $user,
        ]);
    }

    // DELETE /api/users/{user} (auth + user.owner)
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        // hapus token dulu agar bersih
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
    }

    // GET /api/users/{user}/bukus (auth) - akses buku dari user via endpoint api
    // Hanya boleh akses bukus milik sendiri, user lain -> 403
    public function bukus(Request $request, $userId)
    {
        if ((int) $userId !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: tidak bisa melihat buku milik user lain.',
            ], 403);
        }

        $target = User::with('bukus')->find($userId);

        if (! $target) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $target->bukus,
        ]);
    }
}
