<?php

namespace App\Providers;

use App\Composers\TestComposer;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
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
        App::setLocale('ru');
        View::share('site_title', env('APP_NAME'));

        View::composer(['admin.about', 'admin.contact'], TestComposer::class);
    }
}
