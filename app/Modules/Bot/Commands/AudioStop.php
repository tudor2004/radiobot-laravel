<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioStop
 */
class AudioStop implements CommandContract
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
        return '!audio stop';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Stops playing.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.playback.stop',
            'params' => [],
            'id' => 1,
        ]);

        return 'Alright, I\'ve stopped playing music.';
    }
}