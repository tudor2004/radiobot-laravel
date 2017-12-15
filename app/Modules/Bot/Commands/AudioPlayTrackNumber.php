<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioPlayTrackNumber
 */
class AudioPlayTrackNumber implements CommandContract
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
        return '!audio play( track (.+))?';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Play track by track number. If no track is given than it just plays.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $trackId = (int)$this->getTrackId($command);

        $params = [];

        if ($trackId) {
            $params = [
                'tlid' => $trackId
            ];
        }

        $response = $client->call([
            'method' => 'core.playback.play',
            'params' => $params,
            'id'     => 1,
        ]);


        if ($trackId) {
            $nowPlayingMessage = $this->getNowPlayingMessage();

            if(!empty($nowPlayingMessage))
            {
                return $nowPlayingMessage;
            }

            return 'Playing track id ' . $trackId . '.';
        }
        else
        {
            $nowPlayingMessage = $this->getNowPlayingMessage();

            if(!empty($nowPlayingMessage))
            {
                return $nowPlayingMessage;
            }
            else
            {
                return 'Playing from where I left off.';
            }
        }
    }

    /**
     * Extract track name from command.
     *
     * @param string $command
     *
     * @return string|null
     *
     * @throws \Exception
     */
    private function getTrackId(string $command)
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if (is_array($matches) && isset($matches[2])) {
            return $matches[2];
        }

        return null;
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