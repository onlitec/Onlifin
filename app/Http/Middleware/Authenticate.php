<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Limpa a sessão antiga se existir
            if ($request->session()->has('auth')) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return route('login');
        }
        return null;
    }
} 