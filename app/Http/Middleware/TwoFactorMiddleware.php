<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // LOGIC:
        // 1. Is the user logged in? (auth()->check())
        // 2. Do they have a 'two_factor_code' in the database? (If YES, it means they are NOT verified yet)
        if (auth()->check() && $user->two_factor_code) {
            
            // 3. Are they trying to access a verification route? (verify.*)
            // If NOT, we must stop them and redirect them to the "Enter Code" page.
            if (!$request->is('verify*')) {
                return redirect()->route('verify.index');
            }
        }

        return $next($request);
    }
}