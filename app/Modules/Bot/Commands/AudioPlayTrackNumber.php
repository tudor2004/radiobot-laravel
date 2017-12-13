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
        return '!audio play track (.+)';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Play track by track number.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $trackId = $this->getTrackId($command);

        $response = $client->call([
            'method' => 'core.playback.play',
            'params' => [
                'tlid' => $trackId,
            ],
            'id' => 1,
        ]);

        return 'Playing track id ' . $trackId . '.';
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
    private function getTrackId(string $command): string
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if(is_array($matches) && isset($matches[1]))
        {
            return $matches[1];
        }

        throw new \Exception('Invalid track number.');
    }
}