<?php

namespace RadioBot\Modules\Bot\Bots;

use RadioBot\Modules\Bot\Commands\RadioOffCommand;
use RadioBot\Modules\Bot\Commands\RadioOnCommand;
use RadioBot\Modules\Bot\Contracts\BotContract;

/**
 * Class Radio
 */
class Radio extends AbstractBot implements BotContract
{
    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Radio';
    }

    /**
     * @inheritDoc
     */
    public function commands(): array
    {
        return [
            RadioOnCommand::class,
            RadioOffCommand::class
        ];
    }

}