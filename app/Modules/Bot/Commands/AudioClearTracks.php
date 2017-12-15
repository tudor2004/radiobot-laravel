<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioClearTracks
 */
class AudioClearTracks implements CommandContract
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
        return '!audio clear tracks';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Clear the track list.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.tracklist.clear',
            'params' => [],
            'id' => 1,
        ]);

        return 'Ok, track list is empty.';
    }
}