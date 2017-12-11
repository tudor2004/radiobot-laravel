<?php

namespace RadioBot\Modules\Bot\Bots;

use RadioBot\Modules\Bot\Contracts\CommandContract;
use RadioBot\Modules\Bot\Exceptions\BotException;

/**
 * Class AbstractBot
 */
abstract class AbstractBot
{
    /**
     * @var array
     */
    private $data;

    /**
     * AbstractBot constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return array
     */
    abstract protected function commands(): array;

    /**
     * Execute the command.
     */
    public final function run()
    {
        try {
            if (empty($this->commands())) {
                return;
            }

            if (!$this->commandIsSupported($this->getCommandName())) {
                return;
            }

            if (!$this->userCanRunCommand($this->getCommandName(), $this->getUserName())) {
                return;
            }

            /** @var CommandContract $command */
            $command = $this->getBotCommand($this->getCommandName());

            $response = $command->handle();

            $this->respond($response);

        } catch (\Throwable $ex) {

        }
    }

    /**
     * Create chat response.
     *
     * @param string $message
     *
     * @return array
     */
    private function respond(string $message)
    {
        // TODO respond in chat
        return [];
    }

    /**
     * Get the requested command name.
     *
     * @return string
     */
    private function getCommandName(): string
    {
        $message = '';

        if (isset($this->data['text'])) {
            $message = $this->data['text'];
        }

        $command = '';

        if (mb_substr($message, 0, 1) == '!') {
            list($command) = explode(' ', mb_substr($message, 1));
        }

        return $command;
    }

    /**
     * Get the username that requested the command.
     *
     * @return string
     */
    private function getUserName(): string
    {
        if (isset($this->data['sender']) &&
            isset($this->data['sender']['name']) &&
            isset($this->data['sender']['type']) &&
            $this->data['sender']['type'] === 'HUMAN') {
            return $this->data['sender']['name'];
        }

        return '';
    }

    /**
     * Check if requested command is supported by bot.
     *
     * @param string $commandName
     *
     * @return bool
     */
    public function commandIsSupported(string $commandName): bool
    {
        /** @var CommandContract $command */
        foreach ($this->commands() as $command) {
            if ($command->name() == $commandName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user is allowed to execute the command.
     *
     * @param string $commandName
     * @param string $userName
     *
     * @return bool
     *
     * @throws BotException
     */
    private function userCanRunCommand(string $commandName, string $userName): bool
    {
        if(empty($userName))
        {
            return false;
        }

        $botCommand = $this->getBotCommand($commandName);

        foreach($botCommand->allowedUsers() as $user)
        {
            if($user === '*' || $user === $userName)
            {
                return true;
            }
        }

        return true;
    }

    /**
     * Get the requested bot command.
     *
     * @param string $commandName
     *
     * @return CommandContract
     *
     * @throws BotException
     */
    private function getBotCommand(string $commandName): CommandContract
    {
        /** @var CommandContract $command */
        foreach ($this->commands() as $command) {
            if ($command->name() == $commandName) {
                return $command;
            }
        }

        throw new BotException('Invalid command');
    }
}