<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Mendukung banyak role, misal: admin,manager
        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden. Access denied.'], 403);
        }

        return $next($request);
    }
}