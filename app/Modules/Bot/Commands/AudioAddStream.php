<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioAddStream
 */
class AudioAddStream implements CommandContract
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
        return '!audio add stream (.+)';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Add youtube track to track list';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.tracklist.add',
            'params' => [
                'uri' => $this->getTrack($command),
            ],
            'id' => 1,
        ]);

        $addedTracks = [];

        if(isset($response['result']) && is_array($response['result']))
        {
            foreach($response['result'] as $track)
            {
                $addedTrack = '#' . $track['tlid'];

                if(isset($track['track']['name']) && strlen($track['track']['name']))
                {
                    $addedTrack .= ' - ' . $track['track']['name'];
                }

                if(isset($track['track']['length']) && strlen($track['track']['length']))
                {
                    $addedTrack .= ' [' . gmdate('H:i:s', $track['track']['length'] / 1000) . ']';
                }

                $addedTracks[] = $addedTrack;
            }
        }

        if(count($addedTracks))
        {
            return 'Stream added to track list: ' . PHP_EOL . implode(PHP_EOL, $addedTracks);
        }

        return 'Stream could not be added to track list.';
    }

    /**
     * Extract track name from command.
     *
     * @param string $command
     *
     * @return string
     *
     * @throws \Exception
     */
    private function getTrack(string $command): string
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if(is_array($matches) && isset($matches[1]))
        {
            return $matches[1];
        }

        throw new \Exception('Invalid track name');
    }
}