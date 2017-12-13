<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;

/**
 * Class AudioOnCommand
 */
class AudioOnCommand implements CommandContract
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
        return '!audio on';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Turns audio on';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        return 'Turning audio on';
    }
}