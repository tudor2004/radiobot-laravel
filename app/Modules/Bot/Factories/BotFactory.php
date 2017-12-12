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
     * Create bot by bot name.
     *
     * @param string $bot
     * @param array  $data
     *
     * @return \Illuminate\Foundation\Application|mixed|string
     *
     * @throws BotFactoryException
     */
    public function make(string $bot, array $data): BotContract
    {
        try {
            $bot = app($bot, ['data' => $data]);

            if(!$bot instanceof BotContract)
            {
                throw new BotFactoryException('Invalid bot.');
            }

            return $bot;
        } catch (\Throwable $ex) {
            throw new BotFactoryException('Bot does not exists');
        }
    }
}