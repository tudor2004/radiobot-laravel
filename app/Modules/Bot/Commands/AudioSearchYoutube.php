<?php

namespace RadioBot\Modules\Bot\Commands;

use Alaouy\Youtube\Facades\Youtube;
use RadioBot\Modules\Bot\Contracts\CommandContract;

/**
 * Class AudioSearchYoutube
 */
class AudioSearchYoutube implements CommandContract
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
        return '!audio search youtube (.+)';
    }

    /**
     * @inheritDoc
     */
    public function description(): string
    {
        return 'Search youtube for the given keyword';
    }

    /**
     * @inheritDoc
     */
    public function handle(string $command): string
    {
        $keyword = $this->getKeyword($command);

        if (empty($keyword)) {
            return 'You have to give me a keyword so that I can search for something...';
        }

        $results = Youtube::searchVideos($keyword);

        if ($results === false) {
            return 'Nothing found...';
        }

        $foundVideoIds = [];

        foreach ($results as $result) {
            $foundVideoIds[] = $result->id->videoId;
        }

        $videoList = Youtube::getVideoInfo($foundVideoIds);

        $resultsMessage = [
            'I\'ve found following tracks on YouTube:'
        ];

        foreach ($videoList as $video) {
            $videoMessage = 'https://youtu.be/' . $video->id . ' - ' . $video->snippet->title . ' ' . '[' . $this->convertDuration($video->contentDetails->duration) . ']';

            $resultsMessage[] = $videoMessage;
        }

        return implode(PHP_EOL, $resultsMessage);
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
    private function getKeyword(string $command)
    {
        preg_match('/' . $this->name() . '/', $command, $matches);

        if (is_array($matches) && isset($matches[1])) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Convert YouTube time to format H:i:s
     *
     * @param $youtubeTime
     *
     * @return string
     */
    private function convertDuration($youtubeTime)
    {
        $start = new \DateTime('@0'); // Unix epoch
        $start->add(new \DateInterval($youtubeTime));

        return $start->format('H:i:s');
    }
}