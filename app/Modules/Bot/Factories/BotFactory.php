<?php

namespace RadioBot\Modules\Bot\Factories;

use RadioBot\Modules\Bot\Contracts\BotContract;
use RadioBot\Modules\Bot\Exceptions\BotFactoryException;

/**
 * Class BotFactory
 */
class BotFactory
{
    /**
     * @var array
     */
    public static $bots = [
        'radio' => 'radio',
    ];

    /**
     * Create bot by bot name.
     *
     * @param string $botName
     * @param array  $data
     *
     * @return \Illuminate\Foundation\Application|mixed|string
     */
    public function make(string $botName, array $data): BotContract
    {
        try {
            if (isset(static::$bots[$botName])) {
                return app(static::$bots[$botName], [
                    'data' => $data
                ]);
            }

            throw new BotFactoryException('Bot does not exists');
        } catch (\Throwable $ex) {
            return json_encode($ex);
        }
    }
}