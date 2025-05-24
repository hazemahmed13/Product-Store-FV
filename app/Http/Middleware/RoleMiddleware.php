<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // If user is not authenticated and role is 'guest', allow access
        if (!$request->user() && $role === 'guest') {
            return $next($request);
        }

        // If user is authenticated, check their role
        if ($request->user() && $request->user()->hasRole($role)) {
            return $next($request);
        }

        // If user is not authenticated and role is not 'guest', deny access
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Please login.'], 401);
            }
            return redirect()->route('login');
        }

        abort(403, 'Unauthorized action.');
    }
}
