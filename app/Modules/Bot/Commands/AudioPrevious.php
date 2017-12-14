<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;
use RadioBot\Modules\Mopidy\Client\MopidyClient;

/**
 * Class AudioPrevious
 */
class AudioPrevious implements CommandContract
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
        return '!audio previous';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Play the previous track.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.playback.previous',
            'id'     => 1,
            'params' => [],
        ]);

        $nowPlayingMessage = $this->getNowPlayingMessage();

        if (!empty($nowPlayingMessage)) {
            return $nowPlayingMessage;
        }

        return 'Nothing else to play.';
    }

    /**
     * Get the now playing message.
     *
     * @return string
     */
    private function getNowPlayingMessage(): string
    {
        // if we don't sleep, modipy will deliver us false results
        sleep(3);

        try {
            /** @var MopidyClient $client */
            $client = app(MopidyClient::class);

            $response = $client->call([
                'method' => 'core.playback.get_current_tl_track',
                'params' => [],
                'id'     => 1,
            ]);

            if (isset($response['result'])) {
                $track = $response['result'];

                $message = 'Now playing: ' . PHP_EOL . '#' . $track['tlid'];

                if (isset($track['track']['name']) && strlen($track['track']['name'])) {
                    $message .= ' - ' . $track['track']['name'];
                }

                if (isset($track['track']['length']) && strlen($track['track']['length'])) {
                    $message .= ' [' . gmdate('H:i:s', $track['track']['length'] / 1000) . ']';
                }

                return $message;
            }
        } catch (\Exception $e) {
        }

        return '';
    }
}