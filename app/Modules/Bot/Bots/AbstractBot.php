<?php

namespace RadioBot\Modules\Bot\Bots;

use Psy\Command\Command;
use RadioBot\Modules\Bot\Contracts\BotContract;
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
     *
     * @return array
     */
    public final function run()
    {
        try {
            if (empty($this->commands())) {
                return $this->respond('Sorry, but I have found no registered command.');
            }

            if (!$this->botCanRunCommand($this->getCommandName())) {
                return $this->respond('Sorry, but the current bot cannot run this command.');
            }

            if (!$this->userCanRunCommand($this->getCommandName(), $this->getUserName())) {
                return $this->respond('Hey, what are you doing?! You are not allowed to run this command...');
            }

            /** @var CommandContract $command */
            $command = $this->getBotCommand($this->getCommandName());

            $response = $command->handle($this->getCommandName());

            return $this->respond($response);

        } catch (\Throwable $ex) {
            return $this->respond('Sorry, but something went wrong: ' . $ex->getMessage());
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
        return [
            'text' => $message
        ];
    }

    /**
     * Get the requested command name.
     *
     * @return string
     */
    private function getCommandName(): string
    {
        $command = '';

        if (isset($this->data['text'])) {
            $command = $this->data['text'];
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
        if (isset($this->data['sender']) && isset($this->data['sender']['name']) && isset($this->data['sender']['type']) && $this->data['sender']['type'] === 'HUMAN') {
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
    public function botCanRunCommand(string $commandName): bool
    {
        try {
            $this->getBotCommand($commandName);

            return true;
        } catch (\Throwable $ex) {

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
        if (empty($userName)) {
            return false;
        }

        $botCommand = $this->getBotCommand($commandName);

        foreach ($botCommand->allowedUsers() as $user) {
            if ($user === '*' || $user === $userName) {
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
        // TODO we need to check here for regular expressions so that we also allow command like !audio on hello world omg

        /** @var CommandContract $command */
        foreach ($this->commands() as $botCommand) {
            try {
                $command = app($botCommand);

                if ($command instanceof CommandContract && preg_match('/' . $command->name() . '/', $commandName) === 1) {
                    return $command;
                }
            } catch (\Throwable $ex) {

            }
        }

        throw new BotException('Invalid command');
    }
}