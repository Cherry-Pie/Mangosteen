<?php

namespace App\Providers;

use App\Auth\MangosteenGuard;
use App\Auth\Providers\MangoProvider;
use Illuminate\Support\Facades\Auth;
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
        Auth::extend('mangosteen', function ($app) {
            $guard = new MangosteenGuard(
                'mangosteen',
                $app->get('config')->get('mango.password'),
                $this->app['session.store'],
            );

            return $guard;
        });

    }
}
