<?php

namespace App\Http\Middleware;

use App\Models\Buku;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBukuOwner
{
    /**
     * Middleware: pastikan buku yang diakses milik user yang login.
     * Dipakai untuk show / update / delete buku.
     * Jika bukan miliknya -> 403 Forbidden.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Laravel route model binding: parameter bisa bernama {buku} atau {id}
        $bukuParam = $request->route('buku') ?? $request->route('id');

        $buku = $bukuParam instanceof Buku
            ? $bukuParam
            : Buku::find($bukuParam);

        if (! $buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        if ($buku->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: buku ini milik user lain, tidak bisa diakses.',
            ], 403);
        }

        // tempel model agar controller tidak query ulang
        $request->attributes->set('buku_owned', $buku);

        return $next($request);
    }
}
