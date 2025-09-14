<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // First check if user is blocked
        if ($user->is_blocked) {
            // Clear this user's sessions immediately
            DB::table('sessions')->where('user_id', $user->id)->delete();
            
            // Logout the user
            Auth::logout();
            
            // Invalidate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been blocked. Please contact administrator for assistance.'
            ]);
        }

        // Check if user has staff role and can access dashboard
        if (!$user->canAccessDashboard()) {
            // If user is a customer, redirect to customer welcome page
            if ($user->isCustomer()) {
                return redirect()->route('customer.welcome')->withErrors([
                    'access' => 'Access denied. Dashboard is for staff members only.'
                ]);
            }
            
            // For unknown roles, logout and redirect to login
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'email' => 'Access denied. Only staff members can access the dashboard.'
            ]);
        }

        return $next($request);
    }
}