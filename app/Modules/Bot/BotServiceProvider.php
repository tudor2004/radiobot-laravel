<?php

namespace RadioBot\Modules\Bot;

use Illuminate\Support\ServiceProvider;
use RadioBot\Modules\Bot\Factories\BotFactory;

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
        foreach(BotFactory::$bots as $bot)
        {
            $this->app->register($bot, '\\RadioBot\\Modules\\Bot\\Bots\\' . ucfirst($bot));
        }

        $this->app->register(BotRouteServiceProvider::class);
    }
}