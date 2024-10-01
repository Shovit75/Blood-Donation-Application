<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // User is not authenticated, redirect to login page
            return redirect()->route('backend.login');
        }

        // User is authenticated, continue with the request
        return $next($request);
    }
}
