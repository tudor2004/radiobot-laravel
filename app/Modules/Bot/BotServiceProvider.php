<?php

namespace RadioBot\Modules\Bot;

use Illuminate\Support\ServiceProvider;

/**
 * Class BotServiceProvider
 */
class BotServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {

    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->register(BotRouteServiceProvider::class);
    }
}