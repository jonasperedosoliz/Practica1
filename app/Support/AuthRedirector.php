<?php

namespace App\Support;

use App\Models\User;

class AuthRedirector
{
    public static function home(?User $user = null): string
    {
        $user ??= auth()->user();

        if ($user?->isAdmin()) {
            return route('dashboard', absolute: false);
        }

        return route('catalogo', absolute: false);
    }
}
