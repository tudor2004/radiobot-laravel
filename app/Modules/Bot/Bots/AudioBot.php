<?php

namespace RadioBot\Modules\Bot\Bots;

use RadioBot\Modules\Bot\Commands\AudioAddStream;
use RadioBot\Modules\Bot\Commands\AudioAddYoutubeTrack;
use RadioBot\Modules\Bot\Commands\AudioClearTracks;
use RadioBot\Modules\Bot\Commands\AudioCurrentTrack;
use RadioBot\Modules\Bot\Commands\AudioCurrentVolume;
use RadioBot\Modules\Bot\Commands\AudioGetTracks;
use RadioBot\Modules\Bot\Commands\AudioHelp;
use RadioBot\Modules\Bot\Commands\AudioPlayNext;
use RadioBot\Modules\Bot\Commands\AudioPlayTrackNumber;
use RadioBot\Modules\Bot\Commands\AudioPlayPrevious;
use RadioBot\Modules\Bot\Commands\AudioRandom;
use RadioBot\Modules\Bot\Commands\AudioSearchYoutube;
use RadioBot\Modules\Bot\Commands\AudioStop;
use RadioBot\Modules\Bot\Commands\AudioVolume;
use Tudorica\GoogleBot\Contracts\BotContract;
use Tudorica\GoogleBot\Services\BotService;

/**
 * Class AudioBot
 */
class AudioBot implements BotContract
{
    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Radio';
    }

    /**
     * @inheritDoc
     */
    public function commands(): array
    {
        return [
            AudioAddStream::class,
            AudioAddYoutubeTrack::class,
            AudioCurrentTrack::class,
            AudioPlayNext::class,
            AudioPlayPrevious::class,
            AudioPlayTrackNumber::class, // we have to register this after next and previous because of regex conflict
            AudioStop::class,
            AudioGetTracks::class,
            AudioSearchYoutube::class,
            AudioClearTracks::class,
            AudioVolume::class,
            AudioCurrentVolume::class,
            AudioHelp::class,
            AudioRandom::class
        ];
    }
}