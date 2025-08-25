<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Adjust this check to however you store roles/permissions
        if (! $user || ($user->role ?? null) !== 'admin') {
            abort(403, 'Admins only.');
        }

        return $next($request);
    }
}
