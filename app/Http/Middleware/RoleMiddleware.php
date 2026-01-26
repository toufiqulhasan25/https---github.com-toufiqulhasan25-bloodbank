<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // ১. চেক করবে ইউজার লগইন করা আছে কি না
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // ২. চেক করবে ইউজারের রোল আপনার দেওয়া রোলের সাথে মিলে কি না
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action. You do not have the required role.');
        }

        return $next($request);
    }
}