<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = session('user_role');

        if (! $userRole) {
            return redirect()->route('login.index')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak!');
        }

        return $next($request);
    }
}
