<?php

namespace RadioBot\Modules\Bot\Commands;

/**
 * Class RadioOnCommand
 */
class RadioOnCommand
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
        return 'on';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Turns radio on';
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        return 'Turning radio on';
    }
}