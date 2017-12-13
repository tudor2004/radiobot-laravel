<?php

namespace RadioBot\Modules\Mopidy;

use Illuminate\Support\ServiceProvider;
use RadioBot\Modules\Mopidy\Client\MopidyClient;

/**
 * Class MopidyServiceProvider
 */
class MopidyServiceProvider extends ServiceProvider
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
        $this->app->singleton(MopidyClient::class);
    }
}