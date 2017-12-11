<?php

namespace RadioBot\Modules\Bot\Contracts;

/**
 * Interface BotContract
 */
interface BotContract
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return array
     */
    public function commands(): array;

    /**
     * Run bot.
     */
    public function run();
}