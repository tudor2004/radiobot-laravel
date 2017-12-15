<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Bots\AudioBot;
use Tudorica\GoogleBot\Contracts\CommandContract;
use Tudorica\GoogleBot\Factories\BotFactory;

/**
 * Class AudioClearTracks
 */
class AudioHelp implements CommandContract
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
        return '!audio help';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Helps you getting around with me.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var BotFactory $botFactory */
        $botFactory = app(BotFactory::class);

        $bot = $botFactory->make(AudioBot::class, []);

        $help = [
            'I am the Radio Bot. I was developed by Tudor-Dan Ravoiu, the boss!'
        ];

        foreach($bot->commands() as $botCommand)
        {
            try {
                $command = app($botCommand);

                if ($command instanceof CommandContract) {
                    $help[] = '*' . $command->name() . '* - ' . $command->description();
                }
            } catch (\Throwable $ex) {

            }
        }

        return implode(PHP_EOL, $help);
    }
}