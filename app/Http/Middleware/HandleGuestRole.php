<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HandleGuestRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            // Create guest role if it doesn't exist
            $guestRole = Role::firstOrCreate(['name' => 'guest']);
            
            // Add guest role to the request for permission checks
            $request->merge(['guest_role' => $guestRole]);
        }

        return $next($request);
    }
} 