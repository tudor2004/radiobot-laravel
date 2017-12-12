<?php

namespace RadioBot\Modules\Bot\Bots;

use RadioBot\Modules\Bot\Commands\AudioOffCommand;
use RadioBot\Modules\Bot\Commands\AudioOnCommand;
use RadioBot\Modules\Bot\Contracts\BotContract;

/**
 * Class AudioBot
 */
class AudioBot extends AbstractBot implements BotContract
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
            AudioOnCommand::class,
            AudioOffCommand::class
        ];
    }

}