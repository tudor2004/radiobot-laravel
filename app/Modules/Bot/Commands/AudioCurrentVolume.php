<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioCurrentVolume
 */
class AudioCurrentVolume implements CommandContract
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
        return '!audio volume';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Get the current volume.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $response = $client->call([
            'method' => 'core.mixer.get_volume',
            'params' => [],
            'id'     => 1,
        ]);

        if(isset($response['result']))
        {
            return 'Current volume is ' . $response['result'] . '.';
        }

        return 'I really don\'t know what the current volume is...';
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