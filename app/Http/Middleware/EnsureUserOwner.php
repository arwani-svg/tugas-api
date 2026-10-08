<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware sederhana untuk user.
// User hanya boleh lihat / edit / hapus datanya sendiri.
class EnsureUserOwner
{
    public function handle(Request $request, Closure $next)
    {
        // ambil id user dari url, contoh: /api/users/2
        $id = $request->route('user');

        // kalau id di url beda dengan id yang login, tolak
        if ($id != $request->user()->id) {
            return response()->json([
                'message' => 'Tidak bisa akses data user lain'
            ], 403);
        }

        return $next($request);
    }
}
