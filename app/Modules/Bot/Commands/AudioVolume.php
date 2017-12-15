<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioVolume
 */
class AudioVolume implements CommandContract
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
        return '!audio volume (.+)';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Set volume.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $volume = (int) $this->getVolume($command);

        $response = $client->call([
            'method' => 'core.mixer.set_volume',
            'params' => [
                'volume' => $volume
            ],
            'id'     => 1,
        ]);

        return 'Ok, volume is now ' . $volume . '.';
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
    private function getVolume(string $command): string
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if(is_array($matches) && isset($matches[1]))
        {
            $volume = $matches[1];

            if($volume < 0)
            {
                $volume = 0;
            }

            if($volume > 100)
            {
                $volume = 100;
            }

            return $volume;
        }

        throw new \Exception('Invalid volume.');
    }
}