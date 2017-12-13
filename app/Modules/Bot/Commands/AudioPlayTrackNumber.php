<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Bot\Contracts\CommandContract;
use RadioBot\Modules\Mopidy\Client\MopidyClient;

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

        $trackId = (int) $this->getTrackId($command);

        $params = [];

        if($trackId)
        {
            $params = [
                'tlid' => $trackId
            ];
        }

        $response = $client->call([
            'method' => 'core.playback.play',
            'params' => $params,
            'id' => 1,
        ]);

        if($trackId)
        {
            return 'Playing track id ' . $trackId . '.';
        }

        return 'Playing from where I left off.';
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

        if(is_array($matches) && isset($matches[2]))
        {
            return $matches[2];
        }

        return null;
    }
}