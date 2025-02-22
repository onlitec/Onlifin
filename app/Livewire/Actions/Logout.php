<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth::guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
