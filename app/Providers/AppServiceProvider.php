<?php

namespace App\Providers;

use App\View\Composers\SidebarComposer;
use App\View\Composers\TopbarComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.admin');
        Paginator::defaultSimpleView('vendor.pagination.admin');

        // View Composers — wspólne dane layoutu bez logiki w Blade.
        View::composer('layouts.sidebar', SidebarComposer::class);
        View::composer('layouts.topbar', TopbarComposer::class);
    }
}
