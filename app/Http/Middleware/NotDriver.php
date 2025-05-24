<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotDriver
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('driver')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'This page is not available for drivers.'], 403);
            }
            
            return redirect()->route('driver.orders.index')
                ->with('error', 'This page is not available for drivers. You can manage deliveries here.');
        }

        return $next($request);
    }
} 