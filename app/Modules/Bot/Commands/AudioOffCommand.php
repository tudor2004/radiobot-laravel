<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;

/**
 * Class AudioOffCommand
 */
class AudioOffCommand implements CommandContract
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
        return '!audio off';
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
    public function handle(string $command): string
    {
        return 'Turning radio off';
    }
}