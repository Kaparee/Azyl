<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Topbar wyszukuje na różnych trasach — konfiguracja jest w config/search.php.
 */
class TopbarComposer
{
    public function compose(View $view): void
    {
        $searchConfig = null;

        // Szukamy pierwszej pasującej trasy — każda sekcja ma inne pole i placeholder.
        foreach (config('search.routes', []) as $routeName => $config) {
            if (request()->routeIs($routeName)) {
                $searchConfig = $config;
                break;
            }
        }

        $view->with([
            'searchConfig' => $searchConfig,
            'userRole' => Auth::user()?->role?->name,
        ]);
    }
}
