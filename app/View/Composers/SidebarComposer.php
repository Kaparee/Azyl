<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Sidebar potrzebuje roli użytkownika — pobieramy ją tutaj, nie w pliku Blade.
 */
class SidebarComposer
{
    public function compose(View $view): void
    {
        // Null-safe — gość też widzi sidebar, ale bez linków do panelu.
        $view->with('userRole', Auth::user()?->role?->name);
    }
}
