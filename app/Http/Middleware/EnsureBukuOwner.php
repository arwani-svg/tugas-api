<?php

namespace App\Http\Middleware;

use App\Models\Buku;
use Closure;
use Illuminate\Http\Request;

// Middleware sederhana untuk tugas.
// Tujuannya: user tidak boleh buka / edit / hapus buku milik user lain.
class EnsureBukuOwner
{
    public function handle(Request $request, Closure $next)
    {
        // ambil id buku dari url, contoh: /api/bukus/1
        $id = $request->route('buku');

        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        // kalau buku ini bukan milik user yang login, tolak
        if ($buku->user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Tidak bisa akses, ini buku milik user lain'
            ], 403);
        }

        return $next($request);
    }
}
