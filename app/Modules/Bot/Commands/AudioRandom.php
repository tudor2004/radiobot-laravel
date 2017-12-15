<?php

namespace RadioBot\Modules\Bot\Commands;

use RadioBot\Modules\Mopidy\Client\MopidyClient;
use Tudorica\GoogleBot\Contracts\CommandContract;

/**
 * Class AudioRandom
 */
class AudioRandom implements CommandContract
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
        return '!audio random (on|off)';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Turn random on or off.';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        /** @var MopidyClient $client */
        $client = app(MopidyClient::class);

        $isRandom = $this->getRandomValue($command);

        $response = $client->call([
            'method' => 'core.tracklist.set_random',
            'id'     => 1,
            'params' => [
                'value' => $isRandom,
            ],
        ]);

        if($isRandom === true)
        {
            return 'Ok, random is now active';
        }

        return 'Ok, random is now inactive';
    }

    /**
     * Get random value.
     *
     * @param string $command
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function getRandomValue(string $command): bool
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if(is_array($matches) && isset($matches[1]))
        {
            return $matches[1] === 'on';
        }

        throw new \Exception('Invalid random.');
    }
}