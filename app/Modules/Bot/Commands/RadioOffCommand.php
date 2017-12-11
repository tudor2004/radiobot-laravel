<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;

/**
 * Class RadioOffCommand
 */
class RadioOffCommand implements CommandContract
{
    /**
     * @inheritdoc
     */
    public function allowedUsers(): array
    {
        return ['*'];
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'off';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Turns radio off';
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        return 'Turning radio off';
    }
}