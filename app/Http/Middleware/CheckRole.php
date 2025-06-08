<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // public function handle(Request $request, Closure $next, string $role): Response
    // {
    //     if (!auth()->check()) {
    //         return redirect('/login');
    //     }

    //     $user = auth()->user();
        
    //     // Jika user belum memilih role
    //     if (empty($user->role)) {
    //         return redirect()->route('role.selection');
    //     }

    //     // Jika role user tidak sesuai dengan yang diizinkan
    //     if ($user->role !== $role) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
