<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki level 'admin'
        if (Auth::check() && Auth::user()->level === 'admin') {
            // Jika levelnya 'admin', lanjutkan ke halaman admin
            return $next($request);
        }

        // Jika bukan 'admin', arahkan pengguna ke halaman beranda
        return redirect('/')->withErrors('Access denied. Admins only.');
    }
}
