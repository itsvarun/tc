<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        auth()->once(['email' => 'test@test.com', 'password' => 'secret']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        app()->bind(\App\User::class, function() {
            return auth()->user();
        });

    }
}
