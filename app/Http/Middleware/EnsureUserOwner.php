<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwner
{
    /**
     * Middleware: user hanya boleh get/update/delete data dirinya sendiri.
     * Parameter route: {user} atau {id}
     */
    public function handle(Request $request, Closure $next): Response
    {
        $param = $request->route('user') ?? $request->route('id');

        $targetId = is_object($param) ? $param->id : (int) $param;

        if ($targetId !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: tidak bisa akses data user lain.',
            ], 403);
        }

        return $next($request);
    }
}
