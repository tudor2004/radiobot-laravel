<?php

namespace RadioBot\Providers;

use Illuminate\Support\ServiceProvider;
use RadioBot\Modules\Bot\BotServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(BotServiceProvider::class);
    }
}
