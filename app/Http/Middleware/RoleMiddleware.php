<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $company = null, $permission = null)
    {
        if(!auth()->user()->hasRole($company, $role)) {
            return redirect('dashboard');
        }
        if($permission !== null && !auth()->user()->can($permission)) {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
