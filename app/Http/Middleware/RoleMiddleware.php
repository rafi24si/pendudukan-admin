<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session()->has('user_role')) {
            return redirect()->route('login.index')
                ->with('error', 'Anda harus login.');
        }

        $userRole = session('user_role');

        if (!in_array($userRole, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
