<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;
use RadioBot\Modules\Mopidy\Client\MopidyClient;

/**
 * Class AudioCurrentTrack
 */
class AudioCurrentTrack implements CommandContract
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
        return '!audio current track';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'I\'m gonna tell you the track I\'m currently playing.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.playback.get_current_tl_track',
            'params' => [],
            'id'     => 1,
        ]);

        if (isset($response['result'])) {
            $track = $response['result'];

            $message = 'Currently playing: ' . PHP_EOL . '#' . $track['tlid'];

            if (isset($track['track']['name']) && strlen($track['track']['name'])) {
                $message .= ' - ' . $track['track']['name'];
            }

            if (isset($track['track']['length']) && strlen($track['track']['length'])) {
                $message .= ' [' . gmdate('H:i:s', $track['track']['length'] / 1000) . ']';
            }

            return $message;
        }

        return 'Pretty boring in here... not playing anything.';
    }
}