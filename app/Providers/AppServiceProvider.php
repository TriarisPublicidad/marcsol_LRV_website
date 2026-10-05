<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
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
        View::composer('layouts.app', function ($view) {
            try {
                $settings = Cache::remember('site_settings', 3600, function () {
                    return Setting::pluck('valor', 'clave')->toArray();
                });

                $headerMenus = Cache::remember('site_menus_header', 3600, function () {
                    return MenuItem::header()->with('children')->get();
                });

                $footerMenus = Cache::remember('site_menus_footer', 3600, function () {
                    return MenuItem::footer()->get();
                });

                $view->with('settings', $settings)
                    ->with('headerMenus', $headerMenus)
                    ->with('footerMenus', $footerMenus);
            } catch (\Throwable $e) {
                $view->with('settings', [])
                    ->with('headerMenus', collect())
                    ->with('footerMenus', collect());
            }
        });
    }
}
