<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('AdminMiddleware: User', ['user' => auth()->user()]);
        
        if (!auth()->check()) {
            \Log::info('AdminMiddleware: User not authenticated');
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        if (!auth()->user()->is_admin) {
            \Log::info('AdminMiddleware: User not admin');
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        \Log::info('AdminMiddleware: Access granted');
        return $next($request);
    }
} 