<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KepsekSessionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('role') !== 'kepsek') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses kepala sekolah ditolak. Silakan login sebagai kepala sekolah terlebih dahulu.',
                ], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Silakan login sebagai kepala sekolah terlebih dahulu.');
        }

        return $next($request);
    }
}
