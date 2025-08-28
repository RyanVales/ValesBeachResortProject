<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug: Log that middleware is running
        Log::info('CheckIfBlocked middleware is running');
        
        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User authenticated: ' . $user->email . ' - Blocked: ' . ($user->is_blocked ? 'YES' : 'NO'));
            
            // Get fresh user data from database (not cached)
            $freshUser = \App\Models\User::find(Auth::id());
            
            if ($freshUser && $freshUser->is_blocked) {
                Log::info('User is blocked, logging out: ' . $freshUser->email);
                
                // Clear this user's session immediately
                DB::table('sessions')->where('user_id', $freshUser->id)->delete();
                
                // Logout the user
                Auth::logout();
                
                // Invalidate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been blocked. Please contact administrator for assistance.'
                ]);
            }
        }

        return $next($request);
    }
}