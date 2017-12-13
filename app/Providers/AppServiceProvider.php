<?php

namespace RadioBot\Providers;

use Illuminate\Support\ServiceProvider;
use RadioBot\Modules\Bot\BotServiceProvider;
use RadioBot\Modules\Mopidy\MopidyServiceProvider;

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
        $this->app->register(MopidyServiceProvider::class);
    }
}
