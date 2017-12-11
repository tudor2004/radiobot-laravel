<?php

namespace RadioBot\Modules\Bot;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Dingo\Api\Routing\Router;

class BotRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->version('v1', ['namespace' => '\RadioBot\Modules\Bot\Controllers'], function (Router $router) {
            $router->post('webhook', 'BotController@webhook');
        });
    }
}