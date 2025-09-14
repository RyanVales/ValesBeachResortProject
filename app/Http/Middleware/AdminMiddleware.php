<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Please login to access this area.');
        }

        // Check if user has admin role
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}