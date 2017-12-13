<?php

namespace RadioBot\Modules\Bot\Contracts;

/**
 * Interface CommandContract
 */
interface CommandContract
{
    /**
     * List of allowed users. For everybody: return ['*']
     *
     * @return array
     */
    public function allowedUsers(): array;

    /**
     * Command name.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Description of the command.
     *
     * @return string
     */
    public function description(): string;

    /**
     * Here happens all the magic.
     *
     * @param string $command
     *
     * Run command.
     *
     * @return string
     */
    public function handle(string $command): string;
}