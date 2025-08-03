<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();
        $path = $request->path();

        // If user is trying to access dashboard
        if ($path === 'dashboard' || str_starts_with($path, 'dashboard/')) {
            if ($user->isCustomer()) {
                return redirect('/')->with('error', 'Access denied. Customers cannot access the dashboard.');
            }
        }
        // If user is on homepage and is admin/restaurant user
        elseif ($path === '/' && $user->shouldAccessDashboard()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
