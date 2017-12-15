<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioGetTracks
 */
class AudioGetTracks implements CommandContract
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
        return '!audio get tracks';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Get the tracks.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method'  => 'core.tracklist.get_tl_tracks',
            'id'      => 1,
            'params'  => [],
        ]);

        $currentTracks = [];

        if(isset($response['result']) && is_array($response['result']))
        {
            foreach($response['result'] as $track)
            {
                $currentTrack = '#' . $track['tlid'];

                if(isset($track['track']['name']) && strlen($track['track']['name']))
                {
                    $currentTrack .= ' - ' . $track['track']['name'];
                }

                if(isset($track['track']['length']) && strlen($track['track']['length']))
                {
                    $currentTrack .= ' [' . gmdate('H:i:s', $track['track']['length'] / 1000) . ']';
                }

                $currentTracks[] = $currentTrack;
            }
        }

        if(count($currentTracks))
        {
            return 'Current tracks: ' . PHP_EOL . implode(PHP_EOL, $currentTracks);
        }

        return 'Track list is empty.';
    }
}