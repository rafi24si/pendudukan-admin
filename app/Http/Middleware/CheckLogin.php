<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        // cek session login utama
        if (! session()->has('user_id') || ! session()->has('nama_ic')) {

            // hapus session kotor (jaga-jaga)
            session()->flush();

            return redirect()->route('login.index')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
